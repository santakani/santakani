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
use App\User;

/**
 * Edit profile settings, including name, description and avatar.
 *
 * @author Guo Yunhe guoyunhebrave@gmail.com
 */
class ProfileController extends Controller
{
    /**
     * Show the settings edit page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        return view('pages.settings.profile', ['user' => $request->user()]);
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
            'name' => 'filled|max:255',
            'description' => 'string|nullable|max:255',
            'avatar' => 'image|mimes:jpeg,png,gif',
        ]);

        if ($request->has('name')) {
            $user->name = $request->input('name');
        }

        if ($request->exists('description')) { // Can be empty
            $user->description = $request->input('description');
        }

        if ($request->hasFile('avatar')) {
            $user->avatar_uploaded_at = Carbon::now()->format('Y-m-d H:i:s');
            $user->saveAvatarFile($request->file('avatar')->getPathName());
        }

        $user->save();

        return redirect()->back()->with('status', 'Your profile has been updated!');
    }
}
