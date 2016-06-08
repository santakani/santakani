<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\User;
use Socialite;
use App\Http\Controllers\Controller;

class OAuthController extends Controller
{
    /**
     * Redirect the user to the Facebook authentication page.
     *
     * @return Response
     */
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return Response
     */
    public function handleFacebookCallback()
    {
        return $this->handleProviderCallback('facebook');
    }

    /**
     * Redirect the user to the Google authentication page.
     *
     * @return Response
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return Response
     */
    public function handleGoogleCallback()
    {
        return $this->handleProviderCallback('google');
    }

    /**
     * Redirect the user to the Twitter authentication page.
     *
     * @return Response
     */
    public function redirectToTwitter()
    {
        return Socialite::driver('twitter')->redirect();
    }

    /**
     * Obtain the user information from Twitter.
     *
     * @return Response
     */
    public function handleTwitterCallback()
    {
        return $this->handleProviderCallback('twitter');
    }

    /**
     * General function to handle various of OAuth callback.
     *
     * @param string $provider One of 'facebook', 'google', 'twitter'
     * @return Response
     */
    protected function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->user();

        if (Auth::check()) {
            /*
             * Users have already logged in, assign OAuth accounts to their
             * website accounts. This action is usually done in user settings
             * page.
             */

            // Check if the OAuth account already exists.
            $local_user = User::where($provider.'_id', $user->getId())->first();
            if (count($local_user)) {
                return redirect('settings')->withErrors([$provider,
                    'This account is connected with another user. Disconnect them and try again.']);
            } else {
                $local_user = Auth::user();
                $local_user[$provider.'_id'] = $user->getId();

                if (empty($local_user->email) && !empty($user->getEmail())) {
                    /*
                    * If email not set and OAuth email available, set it with OAuth
                    * email.
                    */
                    $local_user->email = $user->getEmail();
                }

                $local_user->save();

                return redirect('settings');
            }

        } else {
            /*
             * User is not logged in. Use OAuth to login or register. This is usually
             * done in login and register page.
             *
             * Check social id of existing users. --> If found, just login the user.
             */
            $local_user = User::where($provider.'_id', $user->getId())->first();

            if (!count($local_user)) {
                /*
                 * If social id not found, then check the email.
                 */
                if (!empty($user->getEmail())) {
                    $local_user = User::where('email', $user->getEmail())->first();
                }

                if (count($local_user)) {
                    /*
                     * If we found same email, then connect existing user with
                     * OAuth account.
                     */
                    $local_user[$provider.'_id'] = $user->getId();
                    $local_user->save();
                } else {
                    /*
                     * If email doesn't match any users, create new user.
                     */
                    $local_user = User::create([
                        'name' => $user->getName(),
                        'email' => $user->getEmail(),
                        'api_token' => str_random(60),
                        $provider.'_id' => $user->getId(),
                    ]);
                }
            }

            // Login user and remember them.
            Auth::login($local_user, true);

            return redirect('/');
        }
    }
}
