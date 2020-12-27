<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Microsoft\Graph\Graph;

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
        echo "in progress";
    }
}
