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

use Illuminate\Http\Request;

use Carbon\Carbon;

use App\Http\Controllers\Controller;

/**
 * Password settings controller.
 *
 * @author Guo Yunhe guoyunhebrave@gmail.com
 */
class PasswordController extends Controller
{
    /**
     * Edit settings page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        return view('pages.settings.password', ['user' => $request->user()]);
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
            'password' => 'required|confirmed|min:6',
        ]);

        $user->password = bcrypt($request->input('password'));

        $user->save();

        return redirect()->back()->with('status', 'Password has been updated!');

    }
}
