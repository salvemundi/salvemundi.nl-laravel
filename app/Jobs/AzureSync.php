<?php

namespace App\Jobs;

use App\Http\Controllers\AzureController;
use App\Models\Commissie;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Microsoft\Graph\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class AzureSync implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
        //
    }

    public function handle()
    {
        $graph = AzureController::connectToAzure();
        Log::info('RE-SYNCING WITH AZURE');

        // ==========================
        // 1️⃣ Users sync
        // ==========================
        $userArray = $graph->createRequest("GET", '/users/?$top=900')
            ->setReturnType(Model\User::class)
            ->execute();

        $userIDArray = collect();

        foreach ($userArray as $users) {
            $checkUser = User::where('AzureID', $users->getId())->first();

            if (!$checkUser) {
                User::create([
                    'AzureID'     => $users->getId(),
                    'DisplayName' => $users->getDisplayName(),
                    'FirstName'   => $users->getGivenName(),
                    'LastName'    => $users->getSurname(),
                    'PhoneNumber' => $users->getMobilePhone(),
                    'email'       => $users->getMail()
                ]);
            } else {
                $checkUser->DisplayName  = $users->getDisplayName();
                $checkUser->FirstName    = $users->getGivenName();
                $checkUser->LastName     = $users->getSurname();
                $checkUser->email        = $users->getMail();
                $checkUser->PhoneNumber  = $users->getMobilePhone();
                $checkUser->save();
            }

            $userIDArray->push($users->getId());
        }

        // Verwijder users die niet meer in Azure zitten
        User::whereNotIn('AzureID', $userIDArray)->forceDelete();
        User::where('AzureID', null)->forceDelete();

        Log::info('Users fetched');

        // ==========================
        // 2️⃣ Groups sync
        // ==========================
        $groupArray = $graph->createRequest("GET", '/groups')
            ->setReturnType(Model\Group::class)
            ->execute();

        foreach ($groupArray as $group) {
            $CommissieQuery = Commissie::where('AzureID', $group->getId())->first();
            if (!$CommissieQuery) {
                if (Str::contains($group->getDisplayName(), ['|| Salve Mundi'])) {
                    $commissieName = str_replace(" || Salve Mundi", "", $group->getDisplayName());
                    DB::table('groups')->insert([
                        'AzureID'     => $group->getId(),
                        'DisplayName' => $commissieName,
                        'Description' => $group->getDescription(),
                        'email'       => $group->getMail()
                    ]);
                }
            } else {
                $commissieName = str_replace(" || Salve Mundi", "", $group->getDisplayName());
                $CommissieQuery->Description = $group->getDescription();
                $CommissieQuery->DisplayName = $commissieName;
                $CommissieQuery->save();
            }
        }

        Log::info('Groups fetched');

        // ==========================
        // 3️⃣ Safe relations sync
        // ==========================
        $groups = DB::table('groups')->select('id', 'AzureID')->get();

        foreach ($groups as $group) {
            try {
                $endpoint = '/groups/' . $group->AzureID . '/members?$top=100';
                $allMembers = [];

                do {
                    $response = $graph->createRequest("GET", $endpoint)
                        ->setReturnType(Model\User::class)
                        ->execute();

                    if (!$response || count($response) === 0) {
                        throw new \Exception("Geen leden opgehaald voor groep {$group->AzureID}. Sync wordt afgebroken.");
                    }

                    $allMembers = array_merge($allMembers, $response->toArray());
                    $endpoint = $response->getNextLink();

                } while ($endpoint);

                // Alles in transaction zodat het atomic is
                DB::transaction(function() use ($group, $allMembers) {
                    DB::table('groups_relation')->where('group_id', $group->id)->delete();

                    foreach ($allMembers as $member) {
                        $user = DB::table('users')->where('AzureID', $member['id'])->first();
                        if ($user) {
                            DB::table('groups_relation')->insert([
                                'user_id'  => $user->id,
                                'group_id' => $group->id
                            ]);
                        }
                    }
                });

                Log::info("Groep {$group->AzureID} succesvol gesynchroniseerd.");

            } catch (\Throwable $e) {
                Log::error("Fout bij synchronisatie van groep {$group->AzureID}: " . $e->getMessage());
                continue;
            }
        }

        Log::info('Relations safely set');

        // ==========================
        // 4️⃣ User profile pictures
        // ==========================
        $members = DB::table('users')->select('id','AzureID')->get();

        foreach ($members as $member) {
            try {
                $graph->createRequest("GET", '/users/'.$member->AzureID.'/photos/240x240/$value')
                    ->download('storage/users/'.$member->AzureID.'.jpg');

                DB::table('users')
                    ->where('id', $member->id)
                    ->update(['ImgPath' => 'users/'.$member->AzureID.'.jpg']);

            } catch (\Throwable $th) {
                Storage::disk('public')->delete('users/'.$member->AzureID.'.jpg');
                DB::table('users')
                    ->where('id', $member->id)
                    ->update(['ImgPath' => 'images/SalveMundi-Vector.svg']);
            }
        }

        Log::info('Profile pictures fetched');
    }
}
