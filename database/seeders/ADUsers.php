<?php

namespace Database\Seeders;


use App\Http\Controllers\AzureController;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Seeder;

use Microsoft\Graph\Exception\GraphException;
use Microsoft\Graph\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ADUsers extends Seeder
{
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

        $userArray = $graph->createRequest("GET", '/users/?$top=900')
            ->setReturnType(Model\User::class)
            ->execute();
        foreach ($userArray as $users) {
            DB::table('users')->insert(
                array(
                    'AzureID' => $users->getId(),
                    'DisplayName' => $users->getDisplayName(),
                    'FirstName' => $users->getGivenName(),
                    'Lastname' => $users->getSurname(),
                    'PhoneNumber' => "",
                    'email' => $users->getMail()
                )
            );
        }
        echo('Users fetched, fetching groups now.');
        echo("\r\n");
        //
        // Get Groups from Azure
        //

        $grouparray = $graph->createRequest("GET", '/groups')
            ->setReturnType(Model\Group::class)
            ->execute();
        foreach ($grouparray as $groups) {
            if(Str::contains($groups->getDisplayName(), ['|| Salve Mundi']))
            {
                $commissieName = str_replace("|| Salve Mundi", "",$groups->getDisplayName());
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
            }
            catch (\Throwable $th)
            {
                Storage::disk('public')->delete('users/'.$members->AzureID.'.jpg');
                DB::table('users')
                    ->where('id', $members->id)
                    ->update(['ImgPath' => 'images/SalveMundi-Vector.svg']);
            }
        }
        echo('All data successfully fetched!');
    }
}
