<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Illuminate\Http\Request;

use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;
use Illuminate\Support\Facades\DB;

class CreateGroupsTable extends Migration
{
    public function FetchAzureGroups()
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

        $grouparray = $graph->createRequest("GET", '/groups')
                      ->setReturnType(Model\User::class)
                      ->execute();
        foreach ($grouparray as $groups) {
            if($groups->getId() != "7b7cf6e2-b440-4eff-8cdc-ac753bfb27d7")
            {
                DB::table('groups')->insert(
                    array(
                        'AzureID' => $groups->getId(),
                        'DisplayName' => $groups->getDisplayName(),
                        'email' => $groups->getMail()
                    )
                );
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
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('AzureID');
            $table->string('DisplayName');
            $table->string('email')->unique();
            $table->timestamps();
        });
        $this->FetchAzureGroups();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groups');
    }
}
