<?php

namespace App\Http\Controllers\Social;

use Auth;
use Socialite;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Models\UserServiceProvider;
use App\Http\Controllers\Controller;

/**
 * Controls the data flow into a social auth object and updates the view whenever data changes.
 */
class SocialAuthController extends Controller
{

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallbackFromFacebook(Request $request)
    {

        session()->put('state', $request->input('state'));

        $userFromFacebook = Socialite::driver('facebook')->user();

        return $this->handleAuthentication($userFromFacebook, 'facebook');

    }

    /**
     * login facebook
     * @param      <type>  $email  The email user
     * @param      <type>  $clientId        The client id
     */
    public function login($email, $clientId)
    {
        $client = new Client([]);

        $rawResponse = $client->request('POST', config('constants.BASE_URL') . config('constants.AUTH_LOGIN_SOCIAL'), [
            'http_errors' => true,
            'json'        => [
                'email'     => $email,
                'client_id' => $clientId,
            ],
        ]);

        $responseFromApi = json_decode($rawResponse->getBody(), true);

        if ($responseFromApi['errors']) {
            return back()->withErrors();
        } else {
            auth()->loginUsingId($responseFromApi['data']['customer']['users_id'], true);

            session()->put('token', $responseFromApi['data']['token']);

            return redirect()->intended('/');
        }
    }

    /**
     * register facebook
     * @param      array  $userFromFacebook   The user
     */
    public function register($userFromFacebook, $provider)
    {
        $client = new Client([]);

        $rawResponse = $client->request('POST', config('constants.BASE_URL') . config('constants.AUTH_REGISTER_SOCIAL'), [
            'http_errors' => false,
            'json'        => [
                'name'      => $userFromFacebook->getName(),
                'last_name' => $userFromFacebook->getName(),
                'email'     => $userFromFacebook->getEmail(),
                'provider'  => $provider,
                'client_id' => $userFromFacebook->getId(),
            ],
        ]);

        $responseFromApi = json_decode($rawResponse->getBody(), true);

        if ($responseFromApi['errors']) {
            if ($responseFromApi['code'] == 422) {
                return $this->login($userFromFacebook->getEmail(), $userFromFacebook->getId());
            }
            return back()->withErrors($responseFromApi['data']);
        } else {
            return $this->login($userFromFacebook->getEmail(), $userFromFacebook->getId());
        }

    }

    /**
     * redirectToProviderTwitter
     */
    public function redirectToProviderTwitter()
    {
        return Socialite::driver('twitter')->redirect();
    }

    /**
     * handle Provider Callback Twitter
     * @param      \Illuminate\Http\Request  $request  The request
     */
    public function handleProviderCallbackFromTwitter(Request $request)
    {
        session()->put('state', $request->input('state'));

        $userFromTwitter = Socialite::driver('twitter')->user();

        return $this->handleAuthentication($userFromTwitter, 'twitter');
    }

    protected function handleAuthentication($userFromSocialMedia, $provider)
    {
        $userFromPharaWithClientId = UserServiceProvider::where('client_id', $userFromSocialMedia->getId())->first();

        if (is_null($userFromPharaWithClientId)) {
            return $this->register($userFromSocialMedia, $provider);
        }

        return $this->login($userFromSocialMedia->getEmail(), $userFromSocialMedia->getId());
    }
}
