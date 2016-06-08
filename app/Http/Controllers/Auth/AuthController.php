<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\User;
use Socialite;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:user',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'api_token' => str_random(60),
        ]);
    }

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
            $local_user->save();

            return redirect('setting');

        } else {
            $local_user = User::where('facebook_id', $user->getId())->first();

            if (!count($local_user)) {
                $local_user = User::where('email', $user->getEmail())->first();

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

            Auth::login($local_user);

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
            $local_user->save();

            return redirect('setting');

        } else {
            $local_user = User::where('google_id', $user->getId())->first();

            if (!count($local_user)) {
                $local_user = User::where('email', $user->getEmail())->first();

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

            Auth::login($local_user);

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
            $local_user->save();

            return redirect('setting');

        } else {
            $local_user = User::where('twitter_id', $user->getId())->first();

            if (!count($local_user)) {
                $local_user = User::where('email', $user->getEmail())->first();

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

            Auth::login($local_user);

            return redirect('/');
        }
    }
}
