<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;

class GetUsersController extends Controller
{
    
    public function run()
    {
        // $guzzle = new \GuzzleHttp\Client();
        // $url = 'https://login.microsoftonline.com/salvemundi.onmicrosoft.com/oauth2/token';
        // $token = json_decode($guzzle->post($url, [
        // 'form_params' => [
        // 'client_id' => env("OAUTH_APP_ID"),
        // 'client_secret' => env("OAUTH_APP_PASSWORD"),
        // 'resource' => 'https://graph.microsoft.com/',
        // 'grant_type' => 'client_credentials',
        // ],
        // ])->getBody()->getContents());
        // $accessToken = $token->access_token;


        // $graph = new Graph();
        // $graph->setAccessToken($accessToken);
        // $user = $graph->createRequest("GET", '/users?$top=999')
        //               ->setReturnType(Model\User::class)
        //               ->execute();
                         
        // //dd($user);
        // return view('users', compact('user'));   
    }

    public function users()
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
        //dd($user2);

        //todo: kijken of foreach en data kunt veranderen in contr/view
        foreach ($user as $users) 
        {
            $upnuser = $users->getMail();
            $upnuser2 = $users->getJobTitle();
            // dd($upnuser);

            if ($upnuser2 != "") 
            {
                
                try 
                {
                    $photo = $graph->createRequest("GET", '/users/'.$upnuser.'/photos/48x48/$value')->execute();

                    if ($photo != null) 
                    {
                        $photo = $photo->getRawBody();  
                        $photoCheck = true;
                        echo '<img class="pfPhoto" src="data:'.';base64,'.base64_encode($photo).'" />';
                    }
                } 
                catch (\Throwable $th) 
                {
                    // echo'OMEGALUL';
                }
            }            
        }
        return view('users', compact('user', 'photoCheck', 'photo'));
    }
}
