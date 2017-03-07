<?php

/*
 * This file is part of Santakani
 *
 * (c) Guo Yunhe <guoyunhebrave@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Http\Controllers\Settings;

use Auth;
use Hash;

use Illuminate\Http\Request;

use Carbon\Carbon;


use App\Http\Controllers\Controller;
use App\User;

/**
 * Edit account settings, including email address, password and OAuth (Facebook/Google/Twitter)
 *
 * @author Guo Yunhe guoyunhebrave@gmail.com
 */
class AccountController extends Controller
{
    /**
     * Show the settings edit page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        return view('pages.settings.account', ['user' => $request->user()]);
    }

    /**
     * Update settings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $this->validate($request, [
            'email' => 'filled|email|max:255|unique:user,email,'.$user->id,
            'locale' => 'string|in:' . implode(',', config('app.available_locale')),
        ]);

        if ($request->has('email')) {
            $user->email = $request->input('email');
        }

        if ($request->has('locale')) {
            $user->locale = $request->input('locale');
        }

        $user->save();

        return redirect()->back()->cookie('locale', $user->locale)->with('status', 'Account settings have been updated!');
    }
}
