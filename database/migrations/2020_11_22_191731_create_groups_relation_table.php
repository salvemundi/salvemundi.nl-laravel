<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Illuminate\Http\Request;

use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;
use Illuminate\Support\Facades\DB;


class CreateGroupsRelationTable extends Migration
{

    public function FetchAzureGroupMembers()
    {
        $guzzle = new \GuzzleHttp\Client();
        $url = 'https://login.microsoftonline.com/salvemundi.onmicrosoft.com/oauth2/token';
        $token = json_decode($guzzle->post($url, [
            'form_params' => [
            'client_id' => env("OAUTH_APP_ID"),
            'client_secret' => env("OAUTH_APP_PASSWORD"),
            'resource' => 'https://graph.microsoft.com/',
            'grant_type' => 'client_credentials',
            ],
        ])->getBody()->getContents());

        $accessToken = $token->access_token;

        $graph = new Graph();
        $graph->setAccessToken($accessToken);

        $grouparray = DB::table('groups')->select('id', 'AzureID')->get();
        foreach($grouparray as $groupids)
        {
            $relationarray = $graph->createRequest("GET", '/groups/'.$groupids->AzureID.'/members')
            ->setReturnType(Model\User::class)
            ->execute();

            foreach ($relationarray as $memberusers) {
                $memberuser = DB::table('users')->select('id','AzureID')->get()->where('AzureID', '=',$memberusers->getId());
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
    }
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups_relation', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->bigInteger('group_id')->unsigned();
            $table->foreign('group_id')->references('id')->on('groups');
            $table->timestamps();
        });

        $this->FetchAzureGroupMembers();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groups_relation');
    }
}
