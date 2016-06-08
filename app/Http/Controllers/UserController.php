<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
        $this->middleware('trim');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('page.user.index', ['users' => $users]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        if (empty($user)) {
            abort(404);
        }

        return view('page.user.show', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        if (empty($user)) {
            abort(404);
        }

        // Check permission
        if (Gate::denies('edit-user', $user)) {
            abort(403);
        }

        return view('page.user.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (empty($user)) {
            abort(404);
        }

        // Check permission
        if (Gate::denies('edit-user', $user)) {
            abort(403);
        }

        // TODO update user profiles
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

    /**
     * Show user setting page.
     *
     * @return \Illuminate\Http\Response
     */
    public function settings()
    {
        $user = Auth::user();
        return view('page.user.setting', ['user' => $user]);
    }

    /**
     * Show notification page.
     *
     * @return \Illuminate\Http\Response
     */
    public function notification()
    {
        $user = Auth::user();
        return view('page.user.notification', ['user' => $user]);
    }
}
