<?php

namespace Database\Seeders;


use App\Http\Controllers\AzureController;
use App\Models\Commissie;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Microsoft\Graph\Exception\GraphException;
use Microsoft\Graph\Model;
use Throwable;

class ADUsers extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws GraphException
     */

    public function run()
    {
        //
        // Authenticate with Microsoft Azure Active Directory.
        //

        $graph = AzureController::connectToAzure();

        //
        // Get Users from Azure
        //

        //
        // Get Users from Azure
        //
        DB::table('groups_relation')->truncate();
        Log::info('RE-SYNCING WITH AZURE');
        $userArray = $graph->createRequest("GET", '/users/?$top=900')
            ->setReturnType(Model\User::class)
            ->execute();
        $userIDArray = collect();
        foreach ($userArray as $users) {
            $checkUser = User::where('AzureID', $users->getId())->first();
            if(!$checkUser) {
                $newUser = new User;
                $newUser->AzureID = $users->getId();
                $newUser->DisplayName = $users->getDisplayName();
                $newUser->FirstName = $users->getGivenName();
                $newUser->LastName = $users->getSurname();
                $newUser->PhoneNumber = $users->getMobilePhone();
                $newUser->email = $users->getMail();
                $newUser->save();
            } else {
                if($checkUser->email != $users->getMail()){
                    $checkUser->email = $users->getMail();
                    $checkUser->save();
                }
                if($checkUser->PhoneNumber != $users->getMobilePhone()){
                    $checkUser->PhoneNumber = $users->getMobilePhone();
                    $checkUser->save();
                }
            }
            $userIDArray->push($users->getID());
        }
        User::whereNotIn('AzureID', $userIDArray)->forceDelete();
        User::where('AzureID',null)->forceDelete();
        echo('Users fetched, fetching groups now.');
        echo("\r\n");

        //
        // Get Groups from Azure
        //

       // Fetch all groups
        $grouparray = $graph->createRequest("GET", '/groups')
            ->setReturnType(Model\Group::class)
            ->execute();
        foreach ($grouparray as $groups) {
            $CommissieQuery = Commissie::where('AzureID', $groups->getId())->first();
            if(!$CommissieQuery) {
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
            } else {
                $commissieName = str_replace(" || Salve Mundi", "", $groups->getDisplayName());
                $CommissieQuery->Description = $groups->getDescription();
                $CommissieQuery->DisplayName = $commissieName;
                $CommissieQuery->save();
            }
        }
        echo('Groups fetched, setting relation between users and groups now.');
        echo("\r\n");

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
        echo('Relations set, now fetching profile images.');
        echo("\r\n");

        //
        // Get user profile pictures from Azure.
        //

        $memberuser = DB::table('users')->select('id','AzureID')->get();

        foreach($memberuser as $members)
        {
            try
            {
                $image = $graph->createRequest("GET", '/users/'.$members->AzureID.'/photos/240x240/$value')
                    ->download('public/storage/users/'.$members->AzureID.'.jpg');
                DB::table('users')
                    ->where('id', $members->id)
                    ->update(['ImgPath' => 'users/'.$members->AzureID.'.jpg']);
            } catch (Throwable $th) {
                Storage::disk('public')->delete('users/' . $members->AzureID . '.jpg');
                DB::table('users')
                    ->where('id', $members->id)
                    ->update(['ImgPath' => 'images/logo.svg']);
            }
        }


        echo('Images set, now fetching group images.');
        echo("\r\n");

        //
        // Get user profile pictures from Azure.
        //

        $groups = DB::table('groups')->select('id','AzureID')->get();

        foreach($groups as $group)
        {
            try
            {
                $image = $graph->createRequest("GET", '/groups/'.$group->AzureID.'/photos/240x240/$value')
                    ->download('public/storage/groups/'.$group->AzureID.'.jpg');
                DB::table('groups')
                    ->where('id', $group->id)
                    ->update(['ImgPath' => 'users/'.$group->AzureID.'.jpg']);
            } catch (Throwable $th) {
                Storage::disk('public')->delete('users/' . $group->AzureID . '.jpg');
                DB::table('groups')
                    ->where('id', $group->id)
                    ->update(['ImgPath' => 'images/group-salvemundi-placeholder.svg']);
            }
        }

        echo('All data successfully fetched!');
        echo("\r\n");
    }
}
