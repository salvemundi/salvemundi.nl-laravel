<?php

namespace App\Http\Controllers;

use App\Mail\SendMailInschrijving;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Laravel\Cashier\SubscriptionBuilder\RedirectToCheckoutResponse;
use Microsoft\Graph\Exception\GraphException;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;
use Illuminate\Http\Request;
use Microsoft\Graph\Model\Image;
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

    public static function createAzureUser($registration,$transaction)
    {
        if($registration == null)
        {
            Log::error('WHERE IS MY OBJECT');
        }
        $randomPass = Str::random(40);
        $userObject = $registration->user()->first();
        $graph = AzureController::connectToAzure();
        if($registration->insertion != null)
        {

        }
        $data = [
            'accountEnabled' => true,
            'displayName' => $registration->firstName." ".$registration->lastName,
            'givenName' => $registration->firstName,
            'surname' => $registration->lastName,
            'mailNickname' => $registration->firstName,
            'mobilePhone' => $registration->phoneNumber,
            'userPrincipalName' => $userObject->email,
            'passwordProfile' => [
                'forceChangePasswordNextSignIn' => true,
                'password' => $randomPass,
            ],
        ];
        Log::info(json_encode($data));

        $createUser = $graph->createRequest("POST", "/users")
            ->addHeaders(array("Content-Type" => "application/json"))
            ->setReturnType(Model\User::class)
            ->attachBody(json_encode($data))
            ->execute();
        $newUserID = $createUser->getId();
        Log::info('New user id:'.$newUserID);
        $userEmail = $userObject->email;
        $userObject = User::where('email', $userEmail)->first();
        $userObject->AzureID = $newUserID;
        $userObject->save();
        Mail::to($registration->email)
            ->send(new SendMailInschrijving($registration->firstName, $registration->lastName, $registration->insertion, $transaction->paymentStatus, $randomPass, $userEmail));
        return $randomPass;
    }

    public static function fetchSpecificUser($userId)
    {
        $graph = AzureController::connectToAzure();

        try {
            $fetchedUser = $graph->createRequest("GET", '/users/' . $userId)
                ->setReturnType(Model\User::class)
                ->execute();
        } catch (GraphException $e) {
            return false;
        }
        return true;
    }

    public static function updateProfilePhoto($userObject)
    {
        $graph = AzureController::connectToAzure();
        try {
            $fetchedUser = $graph->createRequest("PATCH", '/users/' . $userObject->AzureID . '/photo/\$value')
                ->addHeaders(array("Content-Type" => "image/png"))
                ->upload('storage/'.$userObject->ImgPath);
        } catch (GraphException $e) {
            return false;
        }
        return true;
    }

    public static function addUserToGroup($userObject,$groupObject)
    {
        $data = [
            "@odata.id" => "https://graph.microsoft.com/v1.0/directoryObjects/".$userObject->AzureID,
        ];
        $graph = AzureController::connectToAzure();
        try{
            $graphRequest = $graph->createRequest("POST",'/groups/'.$groupObject->AzureID.'/members/$ref')
                ->addHeaders(array("Content-Type" => "application/json"))
                ->attachBody(json_encode($data))
                ->execute();
        }
        catch(GraphException $e){
            return false;
        }
        return true;
    }

    public static function removeUserFromGroup($userObject, $groupObject)
    {
        $graph = AzureController::connectToAzure();
        try{
            $graphRequest = $graph->createRequest("DELETE", '/groups/'.$groupObject->AzureID.'/members/'.$userObject->AzureID.'/$ref')
                ->execute();
        }
        catch(GraphException $e){
            return false;
        }
        return true;
    }

    public static function DeleteUser(Request $request)
    {
        $userObject = User::where('id', $request->input('id'))->first();
        $userObject = User:find($request->input('id'));
        $graph = AzureController::connectToAzure();
        $userObject->delete();
        try{
            $graphRequest = $graph->createRequest("DELETE", '/users/'.$userObject->AzureID)
                ->execute();
        }
        catch(\Exception $e){
            return redirect('removeLeden')->with('message', 'Het verwijderen in azure is niet gelukt, probeert het opnieuw of raadpleeg de ICT-commissie');
        }
        return redirect('removeLeden')->with('message', 'Het verijderen van gebruiker '.$userObject->FirstName.' is gelukt!');
    }

    public static function accountEnabled(bool $mode, User $user)
    {
        $graph = AzureController::connectToAzure();
        if($mode)
        {
            $data = [
                "@odata.id" => "https://graph.microsoft.com/v1.0/directoryObjects/".$user->AzureID,
                "accountEnabled" => true,
            ];
        }
        else
        {
            $data = [
                "@odata.id" => "https://graph.microsoft.com/v1.0/directoryObjects/".$user->AzureID,
                "accountEnabled" => false,
            ];
        }

        try {
            $graphRequest = $graph->createRequest("PATCH","/users/".$user->AzureID)
                ->addHeaders(array("Content-Type" => "application/json"))
                ->attachBody(json_encode($data))
                ->execute();
            return redirect("admin/leden");
        } catch (GraphException $e){
            return redirect("admin/leden");
        }
    }
}
