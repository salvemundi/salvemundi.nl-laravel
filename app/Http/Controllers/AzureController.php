<?php

namespace App\Http\Controllers;

use App\Mail\SendMailInschrijving;
use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Response;
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
use App\Models\Inschrijving;

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

    public function createAzureUserAPI(Request $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $checkIfUserExists = User::where([
            ['FirstName',  $request->input('firstName')],
            ['LastName', $request->input('lastName')]
            ])->first();
        $newUser = new User;
        $firstName = str_replace(' ', '_', $request->input('firstName'));
        $lastName = str_replace(' ', '_', $request->input('lastName'));
        if($request->input('insertion') == null || $request->input('insertion') == "") {
            $newUser->DisplayName = $request->input('firstName')." ".$request->input('lastName');
            if($checkIfUserExists == null){
                $newUser->email = $firstName.".".$lastName."@lid.salvemundi.nl";
            } else {
                $birthDayDay = date("d", strtotime($request->input('birthday')));
                $newUser->email = $firstName.".".$lastName.$birthDayDay."@lid.salvemundi.nl";
            }
        } else {
            $newUser->DisplayName = $request->input('firstName')." ".$request->input('insertion')." ".$request->input('lastName');
            $insertion = str_replace(' ', '.', $request->input('insertion'));
            if($checkIfUserExists == null){
                $newUser->email = $firstName.".".$insertion.".".$lastName."@lid.salvemundi.nl";
            } else {
                $birthDayDay = date("d", strtotime($request->input('birthday')));
                $newUser->email = $firstName.".".$insertion.".".$lastName.$birthDayDay."@lid.salvemundi.nl";
            }
        }
        $newUser->FirstName = $request->input('firstName');
        $newUser->LastName = $request->input('lastName');
        $newUser->phoneNumber = $request->input('phoneNumber');

        $newUser->ImgPath = "images/logo.svg";
        $newUser->birthday = date("Y-m-d", strtotime($request->input('birthday')));
        $newUser->save();
        try {
            $this->createAzureUser(null, null, $request->input('password'), $newUser);
        } catch(GraphException) {
            return response("User already exists or email format is invalid.", 500);
        }
        return response(null, 200);

    }

    /**
     * @throws GraphException
     * @throws GuzzleException
     */
    public static function createAzureUser(Inschrijving $registration = null, $transaction = null, string $password = null, User $user = null): string
    {
        $randomPass = Str::random(40);
        if($registration == null) {
            $userObject = $user;
        } else {
            $userObject = $registration->user()->first();
        }
        $graph = AzureController::connectToAzure();
        $data = [
            'accountEnabled' => true,
            'displayName' => $registration ? $registration->firstName." ". $registration->lastName : $user->FirstName . " " . $user->LastName,
            'givenName' => $registration ? $registration->firstName : $user->FirstName,
            'surname' => $registration ? $registration->lastName : $user->LastName,
            'mailNickname' => $registration ? $registration->firstName : $user->FirstName,
            'mobilePhone' => $registration ? $registration->phoneNumber : $user->phoneNumber,
            'userPrincipalName' => $userObject->email,
            'passwordProfile' => [
                'forceChangePasswordNextSignIn' => true,
                'password' => $password ?: $randomPass,
            ],
        ];

        $createUser = $graph->createRequest("POST", "/users")
            ->addHeaders(array("Content-Type" => "application/json"))
            ->setReturnType(Model\User::class)
            ->attachBody(json_encode($data))
            ->execute();
        $newUserID = $createUser->getId();
        $userEmail = $userObject->email;
        $userObject = User::where('email', $userEmail)->first();
        $userObject->AzureID = $newUserID;
        $userObject->save();
        // if this isn't from the api request (reffering to createAzureUserAPI function), send an email.
        if($user == null) {
            Mail::to($registration->email)
                ->send(new SendMailInschrijving($registration->firstName, $registration->lastName, $registration->insertion, $transaction->paymentStatus, $randomPass, $userEmail));
        }
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
        #$userObject = User::where('id', $request->input('id'))->first();
        $userObject = User::find($request->input('id'));
        $graph = AzureController::connectToAzure();
        $userObject->forceDelete();
        try{
            $graphRequest = $graph->createRequest("DELETE", '/users/'.$userObject->AzureID)
                ->execute();
        }
        catch(\Exception $e){
            return back()->with('message', 'Het verwijderen in azure is niet gelukt, probeert het opnieuw of raadpleeg de ICT-commissie');
        }
        return back()->with('message', 'Het verijderen van gebruiker '.$userObject->FirstName.' is gelukt!');
    }

    public static function accountEnabled(bool $mode, User $user)
    {
        $graph = AzureController::connectToAzure();
        $data = [
            "@odata.id" => "https://graph.microsoft.com/v1.0/directoryObjects/".$user->AzureID,
            "accountEnabled" => $mode,
        ];

        try {
            $graph->createRequest("PATCH","/users/".$user->AzureID)
                ->addHeaders(array("Content-Type" => "application/json"))
                ->attachBody(json_encode($data))
                ->execute();
            return redirect("admin/leden");
        } catch (GraphException $e){
            return redirect("admin/leden");
        }
    }
}
