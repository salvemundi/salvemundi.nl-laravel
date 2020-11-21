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

        $user = $graph->createRequest("GET", '/groups/a4aeb401-882d-4e1e-90ee-106b7fdb23cc/members')
                      ->setReturnType(Model\User::class)
                      ->execute();
        // dd($user);
        $imgarray = array();
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
                        //echo '<img class="pfPhoto" src="data:'.';base64,'.base64_encode($photo).'" />';
                        array_push($imgarray, $photo);
                    }
                }
                catch (\Throwable $th)
                {
                    //echo'<img class="pfPhoto" src="images/SalveMundiLogo.png" />';
                }
            }
        }
        $userArray = array_merge($user,$imgarray);
        //dd($userArray);
        return view('users', compact('user', 'photoCheck', 'imgarray'));
    }
}
