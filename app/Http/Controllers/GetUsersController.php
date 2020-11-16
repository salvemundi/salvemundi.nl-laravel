<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;

class GetUsersController extends Controller
{
    
    public function run()
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
        $user = $graph->createRequest("GET", '/users?$top=999')
                      ->setReturnType(Model\User::class)
                      ->execute();
                         
        //dd($user);
        return view('users', compact('user'));   
    }
}
