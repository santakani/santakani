<?php

/*
 * This file is part of santakani.com
 *
 * (c) Guo Yunhe <guoyunhebrave@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;

/**
 * SettingController
 *
 * API for updating current user settings.
 *
 * @author Guo Yunhe <guoyunhebrave@gmail.com>
 * @see https://github.com/santakani/santakani.com/wiki/User
 */
class SettingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function profile(Request $request)
    {
        return view('page.setting.profile', ['user' => $request->user()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function account(Request $request)
    {
        return view('page.setting.account', ['user' => $request->user()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function page(Request $request)
    {
        return view('page.setting.page', ['user' => $request->user()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function trash(Request $request)
    {
        return view('page.setting.trash', ['user' => $request->user()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $this->validate($request, [
            'name' => 'max:255',
            'description' => 'max:255',
            'email' => 'email|max:255|unique:user,email,'.$user->id,
            'password' => 'confirmed|min:6',
        ]);

        $user->update($request->only(['name', 'description', 'email']));

        if ($request->has('password')) {
            if ( empty($user->password) ||
                $user->password === bcrypt($request->input('old_password')) ) {

                $user->update([
                    'password' => bcrypt($request->input('password')),
                ]);
            } else {
                return response()->json(['old_password' => ['Old password is incorrect.']], 422);
            }
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (empty($user)) {
            abort(404);
        }

        // Check permission
        if (Gate::denies('delete-user', $user)) {
            abort(403);
        }

        // Delete model from database
        $user->delete();
    }
}
