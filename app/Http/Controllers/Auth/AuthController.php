<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Validator;

use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\User;

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
     * Send the response after the user was authenticated.
     *
     * @see https://github.com/laravel/framework/blob/5.2/src/Illuminate/Foundation/Auth/AuthenticatesUsers.php#L114
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    protected function authenticated(Request $request, User $user)
    {
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json($user->toArray(), 200);
        } else {
            return redirect()->intended($this->redirectPath());
        }
    }

    /**
     * [Override] Get the failed login response instance.
     *
     * @see https://github.com/laravel/framework/blob/5.2/src/Illuminate/Foundation/Auth/AuthenticatesUsers.php#L127
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                $this->loginUsername() => [ $this->getFailedLoginMessage() ],
            ], 422);
        } else {
            return redirect()->back()
                ->withInput($request->only($this->loginUsername(), 'remember'))
                ->withErrors([
                    $this->loginUsername() => [ $this->getFailedLoginMessage() ],
                ]);
        }
    }

    /**
     * [Override] Handle a registration request for the application.
     *
     * @see https://github.com/laravel/framework/blob/5.2/src/Illuminate/Foundation/Auth/RegistersUsers.php#L53
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
        Auth::guard($this->getGuard())->login($this->create($request->all()));
        if ($request->wantsJson() || $request->ajax()) {
            $user = Auth::guard($this->getGuard())->user();
            return response()->json($user->toArray(), 200);
        } else{
            return redirect($this->redirectPath());
        }
    }
}
