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

        $userarray = $graph->createRequest("GET", '/groups/a4aeb401-882d-4e1e-90ee-106b7fdb23cc/members')
                      ->setReturnType(Model\User::class)
                      ->execute();
        //
        // ANYTHING PAST THIS CODE NEEDS TO BE REVAMPED TO WORK WITH DATABASE.
        //

        //dd($userarray);
        $imgarray = array();
        foreach ($userarray as $users)
        {
            $upnuser = $users->getMail();
            $upnuser2 = $users->getJobTitle();
            // dd($upnuser);

            if (true)
            {
                try
                {
                    $photo = $graph->createRequest("GET", '/users/'.$upnuser.'/photo')->execute();

                    if ($photo != null)
                    {
                        //$photo = $photo->getRawBody();
                        $photoCheck = true;
                        //echo '<img class="pfPhoto" src="data:'.';base64,'.base64_encode($photo).'" />';
                        //dd($photo);
                        array_push($imgarray, $photo);
                        file_put_contents('images/'.$users->getID().'.png', base64_decode($photo));
                    }
                }
                catch (\Throwable $th)
                {
                    //echo'<img class="pfPhoto" src="images/SalveMundiLogo.png" />';
                    array_push($userarray, null);
                }
            }
        }
        $imguserarray = array($userarray,$imgarray);
        dd($photo);
        return view('users', compact('user', 'photoCheck', 'imguserarray'));
    }
}
