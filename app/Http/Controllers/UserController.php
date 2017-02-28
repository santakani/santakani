<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Design;
use App\Designer;
use App\Http\Requests;
use App\Place;
use App\Story;
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
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->validate($request, [
            'search' => 'string|nullable|max:20',
        ]);

        $query = User::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', $search . '%')
                ->orWhere('email', 'like', $search . '%');
        }

        $users = $query->paginate(15);

        if ($request->wantsJSON()) {
            return response()->json($users->toArray(), 200);
        } else {
            return view('pages.user.index', ['users' => $users]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $user = User::find($id);

        if (empty($user)) {
            abort(404);
        }

        $tab = $request->input('tab', 'overview');

        if (!in_array($tab, ['overview', 'stories', 'likes'])) {
            $tab = 'overview';
        }

        // Navigation parameter under Likes tab
        $type = $request->input('type', 'design');

        if (!in_array($type, ['design', 'designer', 'place', 'story'])) {
            $type = 'design';
        }

        $data = [
            'user' => $user,
            'tab' => $tab,
            'type' => $type,
        ];

        switch ($tab) {
            case 'overview':
                $data['designers'] = $user->designers;
                $data['places'] = $user->places;
                $data['stories'] = $user->stories()->orderBy('created_at', 'desc')->take(3)->get();
                $data['likes'] = $user->likes()->where('likeable_type', 'design')->with('user')->take(3)->get();
                break;
            case 'stories':
                $data['stories'] = $user->stories()->paginate(12);
                break;
            case 'likes':
                $class = '\\App\\' . ucfirst($type);
                $data['likes'] = $class::whereHas('likes', function ($query) use ($user) {
                    $query->where('user_id', $user->id)->orderBy('created_at', 'desc');
                })->paginate(12);
                break;
        }

        return view('pages.user.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $user = User::find($id);

        if (empty($user)) {
            abort(404);
        }

        // Check permission
        if ($request->user()->cannot('edit-user', $user)) {
            abort(403);
        }

        return view('pages.user.edit', ['user' => $user]);
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
        if ($request->user()->cannot('edit-user', $user)) {
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
    public function destroy(Request $request, $id)
    {
        $user = User::find($id);

        if (empty($user)) {
            abort(404);
        }

        if ($request->user()->cannot('delete-user', $user)) {
            abort(403);
        }

        $user->delete();
    }
}
