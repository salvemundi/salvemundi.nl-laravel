<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Middleware\AzureAuth;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\GenericProvider;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;
use App\TokenStore\TokenCache;
use App\Models\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function signOut(): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
          $tokenCache = new TokenCache();
          $tokenCache->clearTokens();
          Session::forget('id');
          Auth::logout();
          return redirect('/');
    }

    public function signIn(Request $request): RedirectResponse
    {
      // Initialize the OAuth client
      $oauthClient = new GenericProvider([
        'clientId'                => env('OAUTH_APP_ID'),
        'clientSecret'            => env('OAUTH_APP_PASSWORD'),
        'redirectUri'             => env('OAUTH_REDIRECT_URI'),
        'urlAuthorize'            => env('OAUTH_AUTHORITY').env('OAUTH_AUTHORIZE_ENDPOINT'),
        'urlAccessToken'          => env('OAUTH_AUTHORITY').env('OAUTH_TOKEN_ENDPOINT'),
        'urlResourceOwnerDetails' => '',
        'scopes'                  => env('OAUTH_SCOPES')
      ]);

      $authUrl = $oauthClient->getAuthorizationUrl();

      // Save client state so we can validate in callback
      session(['oauthState' => $oauthClient->getState()]);
      // Redirect to AAD signin page
      session(['intended_url' => parse_url(url()->previous(), PHP_URL_PATH)]);
      return redirect()->away($authUrl);
    }

    public function callback(Request $request)
    {
      // Validate state
      $expectedState = session('oauthState');
      $request->session()->forget('oauthState');
      $providedState = $request->query('state');

      if (!isset($expectedState)) {
        // If there is no expected state in the session,
        // do nothing and redirect to the home page.
        return redirect('/');
      }

      if (!isset($providedState) || $expectedState != $providedState) {
        return redirect('/')
          ->with('error', 'Invalid auth state')
          ->with('errorDetail', 'The provided auth state did not match the expected value');
      }

      // Authorization code should be in the "code" query param
      $authCode = $request->query('code');
      if (isset($authCode)) {
        // Initialize the OAuth client
        $oauthClient = new GenericProvider([
          'clientId'                => env('OAUTH_APP_ID'),
          'clientSecret'            => env('OAUTH_APP_PASSWORD'),
          'redirectUri'             => env('OAUTH_REDIRECT_URI'),
          'urlAuthorize'            => env('OAUTH_AUTHORITY').env('OAUTH_AUTHORIZE_ENDPOINT'),
          'urlAccessToken'          => env('OAUTH_AUTHORITY').env('OAUTH_TOKEN_ENDPOINT'),
          'urlResourceOwnerDetails' => '',
          'scopes'                  => env('OAUTH_SCOPES')
        ]);

        try
        {
          // Make the token request
          $accessToken = $oauthClient->getAccessToken('authorization_code', [
            'code' => $authCode
          ]);

          $graph = new Graph();
          $graph->setAccessToken($accessToken->getToken());

          $user = $graph->createRequest('GET', '/me?$select=displayName,mail,mailboxSettings,userPrincipalName,id')
            ->setReturnType(Model\User::class)
            ->execute();

            session(['id' => $user->getId()]);

          $tokenCache = new TokenCache();
          $tokenCache->storeTokens($accessToken, $user);
          $AzureUser = User::where('AzureID',$user->getId())->first();
          $AzureUser->api_token = hash('sha256', strval($accessToken));
          $AzureUser->save();

          Auth::login($AzureUser);
          $intendedUrl = session('intended_url', '/');
          session()->forget('intended_url');
          return redirect($intendedUrl);
        }
        catch (IdentityProviderException $e)
        {
          return redirect('/')
            ->with('error', 'Error requesting access token')
            ->with('errorDetail', $e->getMessage());
        }
      }

      return redirect('/')
        ->with('error', $request->query('error'))
        ->with('errorDetail', $request->query('error_description'));
    }
}
