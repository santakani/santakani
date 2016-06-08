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
        $user = Socialite::driver('facebook')->user();

        if (Auth::check()) {
            $local_user = Auth::user();
            $local_user->facebook_id = $user->getId();

            if (empty($local_user->email) && !empty($user->getEmail())) {
                $local_user->email = $user->getEmail();
            }

            $local_user->save();

            return redirect('setting');

        } else {
            $local_user = User::where('facebook_id', $user->getId())->first();

            if (!count($local_user)) {
                if (!empty($user->getEmail())) {
                    $local_user = User::where('email', $user->getEmail())->first();
                }

                if (count($local_user)) {
                    // Save Facebook ID
                    $local_user->facebook_id = $user->getId();
                    $local_user->save();
                } else {
                    // Create new user
                    $local_user = User::create([
                        'name' => $user->getName(),
                        'email' => $user->getEmail(),
                        'api_token' => str_random(60),
                        'facebook_id' => $user->getId(),
                    ]);
                }
            }

            Auth::login($local_user, true);

            return redirect('/');
        }
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
        $user = Socialite::driver('google')->user();

        if (Auth::check()) {
            $local_user = Auth::user();
            $local_user->google_id = $user->getId();

            if (empty($local_user->email) && !empty($user->getEmail())) {
                $local_user->email = $user->getEmail();
            }

            $local_user->save();

            return redirect('setting');

        } else {
            $local_user = User::where('google_id', $user->getId())->first();

            if (!count($local_user)) {
                if (!empty($user->getEmail())) {
                    $local_user = User::where('email', $user->getEmail())->first();
                }

                if (count($local_user)) {
                    // Save Google ID
                    $local_user->google_id = $user->getId();
                    $local_user->save();
                } else {
                    // Create new user
                    $local_user = User::create([
                        'name' => $user->getName(),
                        'email' => $user->getEmail(),
                        'api_token' => str_random(60),
                        'google_id' => $user->getId(),
                    ]);
                }
            }

            Auth::login($local_user, true);

            return redirect('/');
        }
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
        $user = Socialite::driver('twitter')->user();

        if (Auth::check()) {
            $local_user = Auth::user();
            $local_user->twitter_id = $user->getId();

            if (empty($local_user->email) && !empty($user->getEmail())) {
                $local_user->email = $user->getEmail();
            }

            $local_user->save();

            return redirect('setting');

        } else {
            $local_user = User::where('twitter_id', $user->getId())->first();

            if (!count($local_user)) {
                if (!empty($user->getEmail())) {
                    $local_user = User::where('email', $user->getEmail())->first();
                }

                if (count($local_user)) {
                    // Save Twitter ID
                    $local_user->twitter_id = $user->getId();
                    $local_user->save();
                } else {
                    // Create new user
                    $local_user = User::create([
                        'name' => $user->getName(),
                        'email' => $user->getEmail(),
                        'api_token' => str_random(60),
                        'twitter_id' => $user->getId(),
                    ]);
                }
            }

            Auth::login($local_user, true);

            return redirect('/');
        }
    }
}
