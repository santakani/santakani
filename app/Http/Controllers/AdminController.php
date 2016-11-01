<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Image;
use App\Like;
use App\User;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        return view('pages.admin.index');
    }

    public function user(Request $request)
    {
        $query = User::query();

        if ($request->has('role')) {
            $query->where('role', $request->input('role'));
        }

        if ($request->has('name')) {
            $query->where('name', 'like', '%'.$request->input('name').'%' );
        }

        if ($request->has('email')) {
            $query->where('email', 'like', '%'.$request->input('email').'%' );
        }

        $users = $query->orderBy('id', 'desc')->paginate(100);

        return view('pages.admin.user', ['users' => $users]);
    }

    public function image(Request $request)
    {
        $query = Image::with('parent', 'user');

        $images = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('pages.admin.image', ['images' => $images]);
    }

    public function deletedImage(Request $request)
    {
        return;
    }

    public function like(Request $request)
    {
        return;
    }

    public function comment(Request $request)
    {
        return;
    }
}
