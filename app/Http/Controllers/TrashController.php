<?php

/*
 * This file is part of Santakani
 *
 * (c) Guo Yunhe <guoyunhebrave@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Manage trash of current user.
 *
 * @author Guo Yunhe <guoyunhebrave@gmail.com>
 * @see https://github.com/santakani/santakani.com/wiki/Trash
 */
class TrashController extends Controller
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
     * Redirect to design trash list.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return redirect('trash/design');
    }

    public function design(Request $request)
    {
        return view('pages.trash', [
            'type' => 'design',
            'pages' => $request->user()->designs()->onlyTrashed()->get(),
        ]);
    }

    public function designer(Request $request)
    {
        return view('pages.trash', [
            'type' => 'designer',
            'pages' => $request->user()->designers()->onlyTrashed()->get(),
        ]);
    }

    public function place(Request $request)
    {
        return view('pages.trash', [
            'type' => 'place',
            'pages' => $request->user()->places()->onlyTrashed()->get(),
        ]);
    }

    public function story(Request $request)
    {
        return view('pages.trash', [
            'type' => 'story',
            'pages' => $request->user()->stories()->onlyTrashed()->get(),
        ]);
    }
}
