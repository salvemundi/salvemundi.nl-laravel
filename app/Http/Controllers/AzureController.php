<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Microsoft\Graph\Exception\GraphException;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;

class AzureController extends Controller
{
    public static function connectToAzure(): Graph
    {
        $guzzle = new Client();
        $url = 'https://login.microsoftonline.com/salvemundi.onmicrosoft.com/oauth2/token';
        $token = json_decode($guzzle->post($url, [
            'form_params' => array(
                'client_id' => env("OAUTH_APP_ID"),
                'client_secret' => env("OAUTH_APP_PASSWORD"),
                'resource' => 'https://graph.microsoft.com/',
                'grant_type' => 'client_credentials',
            ),
        ])->getBody()->getContents());

        $accessToken = $token->access_token;

        $graph = new Graph();
        $graph->setAccessToken($accessToken);
        return $graph;
    }

    public static function createAzureUser($registration)
    {
        if($registration == null)
        {
            Log::error('WHERE IS MY OBJECT');
        }
        $randomPass = Str::random(40);
        $graph = AzureController::connectToAzure();
        $data = [
            'accountEnabled' => true,
            'displayName' => $registration->firstName." ".$registration->lastName,
            'givenName' => $registration->firstName,
            'surname' => $registration->lastName,
            'mobilePhone' => $registration->phoneNumber,
            'userPrincipleName' => $registration->firstName.".".$registration->lastName."@lid.salvemundi.nl",
            'passwordProfile' => [
                'forceChangePasswordNextSignIn' => true,
                'password' => $randomPass,
            ],
        ];
        Log::info(json_encode($data));
        try {
            $createUser = $graph->createRequest("POST", "/users")
                ->addHeaders(array("Content-Type" => "application/json"))
                ->setReturnType(Model\User::class)
                ->attachBody(json_encode($data))
                ->execute();
            $newUserID = $createUser->getId();
            AzureController::fetchSpecificUser($newUserID);
            return $randomPass;
        } catch (GraphException $e) {
            return 503;
        }

    }

    public static function fetchSpecificUser($userId)
    {
        $graph = AzureController::connectToAzure();

        $fetchedUser = $graph->createRequest("GET",'/users/'.$userId)
            ->setReturnType(Model\User::class)
            ->execute();

        foreach ($fetchedUser as $users) {
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
    }
}
