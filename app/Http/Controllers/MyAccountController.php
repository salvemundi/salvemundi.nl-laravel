<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;
use App\TokenStore\TokenCache;
use App\Models\Subscription;

class AuthController extends Controller
{
    public function signin()
    {
        $loginUrl = \Microsoft\Graph\Graph::createOAuth2Provider()->getAuthorizationUrl();
        return redirect($loginUrl);
    }

    public function callback(Request $request)
    {
        $tokenCache = new TokenCache();
        try {
            $accessToken = \Microsoft\Graph\Graph::createOAuth2Provider()->getAccessToken('authorization_code', [
                'code' => $request->get('code')
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $this->addError(
                'De autorisatiecode is ongeldig of is al gebruikt. Probeer het opnieuw.',
                $e->getMessage()
            );
            return redirect('/');
        }
    
        $graph = new Graph();
        $graph->setAccessToken($accessToken->getToken());

        $user = $graph->createRequest('GET', '/me?$select=displayName,mail,mailboxSettings,userPrincipalName,givenName,surname,jobTitle,id')
            ->setReturnType(Model\User::class)
            ->execute();
        
        session(['id' => $user->getId()]);
        
        $tokenCache->storeTokens($accessToken, $user);

        // Zoek naar de gebruiker in de database, of maak een nieuwe aan
        $AzureUser = User::where('AzureID', $user->getId())->first();

        if ($AzureUser === null) {
            $AzureUser = new User();
            $AzureUser->AzureID = $user->getId();
            $AzureUser->name = $user->getGivenName();
            $AzureUser->surname = $user->getSurname();
            $AzureUser->DisplayName = $user->getDisplayName();
            $AzureUser->email = $user->getMail();
            $AzureUser->ImgPath = "images/logo.svg";
        }
        
        $AzureUser->api_token = hash('sha256', strval($accessToken));
        $AzureUser->save();

        Auth::login($AzureUser);

        $intendedUrl = session('intended_url', '/');
        session()->forget('intended_url');

        return redirect($intendedUrl);
    }

    public function signout()
    {
        $tokenCache = new TokenCache();
        $tokenCache->clearTokens();
        return redirect('/');
    }

    private function addError($message, $debug = null)
    {
        $flash = [
            'error' => $message
        ];
        if ($debug) {
            $flash['errorDetail'] = $debug;
        }
        Session::flash('flash', $flash);
    }
}
