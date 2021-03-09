<?php

namespace App\Jobs;

use App\Http\Controllers\AzureController;
use App\Models\Commissie;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Microsoft\Graph\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Microsoft\Graph\Exception\GraphException;
use Illuminate\Support\Facades\Log;

class AzureSync implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws GraphException
     */
    public function handle()
    {
        // Connect to Azure
        $graph = AzureController::connectToAzure();
        //
        // Get Users from Azure
        //
        DB::table('groups_relation')->truncate();
        Log::info('RE-SYNCING WITH AZURE');

        $userArray = $graph->createRequest("GET", '/users/?$top=900')
            ->setReturnType(Model\User::class)
            ->execute();
        foreach ($userArray as $users) {
            $checkUser = User::where('AzureID', $users->getId())->first();
            if(!$checkUser) {
                $newUser = new User;
                $newUser->AzureID = $users->getId();
                $newUser->DisplayName = $users->getDisplayName();
                $newUser->FirstName = $users->getGivenName();
                $newUser->LastName = $users->getSurname();
                $newUser->PhoneNumber = "";
                $newUser->email = $users->getMail();
                $newUser->save();
            } else {
                if($checkUser->email != $users->getMail()){
                    $checkUser->email = $users->getMail();
                    $checkUser->save();
                }
            }
        }
        Log::info('Users fetched');
        // Fetch all groups
        $grouparray = $graph->createRequest("GET", '/groups')
            ->setReturnType(Model\Group::class)
            ->execute();
        foreach ($grouparray as $groups) {
            if(!Commissie::where('AzureID', $groups->getId())->first()) {
                if (Str::contains($groups->getDisplayName(), ['|| Salve Mundi'])) {
                    $commissieName = str_replace(" || Salve Mundi", "", $groups->getDisplayName());
                    DB::table('groups')->insert(
                        array(
                            'AzureID' => $groups->getId(),
                            'DisplayName' => $commissieName,
                            'Description' => $groups->getDescription(),
                            'email' => $groups->getMail()
                        )
                    );
                }
            }
        }
        Log::info('Groups fetched');
        //
        // Set relation between groups and users.
        //

        $grouparray = DB::table('groups')->select('id', 'AzureID')->get();
        foreach($grouparray as $groupids)
        {
            $relationarray = $graph->createRequest("GET", '/groups/'.$groupids->AzureID.'/members')
                ->setReturnType(Model\User::class)
                ->execute();

            foreach ($relationarray as $memberUsers) {
                $memberuser = DB::table('users')->select('id','AzureID')->get()->where('AzureID', '=',$memberUsers->getId());
                foreach($memberuser as $uid)
                {
                    DB::table('groups_relation')->insert(
                        array(
                            'user_id' => $uid->id,
                            'group_id' => $groupids->id
                        )
                    );
                }
            }
        }
        Log::info('Relations set');
        //
        // Get user profile pictures from Azure.
        //

        $memberuser = DB::table('users')->select('id','AzureID')->get();
        foreach($memberuser as $members)
        {
            try
            {
                $graph->createRequest("GET", '/users/'.$members->AzureID.'/photos/240x240/$value')
                    ->download('storage/users/'.$members->AzureID.'.jpg');

                DB::table('users')
                    ->where('id', $members->id)
                    ->update(['ImgPath' => 'users/'.$members->AzureID.'.jpg']);
            }
            catch (\Throwable $th)
            {
                Storage::disk('public')->delete('users/'.$members->AzureID.'.jpg');
                DB::table('users')
                    ->where('id', $members->id)
                    ->update(['ImgPath' => 'images/SalveMundi-Vector.svg']);

            }
        }
        Log::info('Profile pictures fetched');
    }
}
