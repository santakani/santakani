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
use DB;
use Gate;
use Illuminate\Http\Request;
use Imagick;

use App\Http\Requests;
use App\Designer;
use App\Image;

/**
 * ImageController
 *
 * Provide RESTful APIs for image resources.
 *
 * @author Guo Yunhe <guoyunhebrave@gmail.com>
 * @see https://github.com/santakani/santakani.com/wiki/Image
 */
class ImageController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Only logged in users can upload images
        $this->middleware('auth', ['except' => ['index','show']]);
        $this->middleware('trim');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Validate data
        $this->validate($request, [
            'my' => 'boolean',
            'user' => 'integer|exists:user,id',
            'parent_type' => 'string',
            'parent_id' => 'integer',
        ]);

        if ($request->has('my')) {
            $images = Image::where('user_id', Auth::user()->id)->get();
        } elseif ($request->has('user')) {
            $images = Image::where('user_id', $request->input('user'))->get();
        } elseif ($request->has('parent_type') && $request->has('parent_id')) {
            $images = Image::where([
                ['parent_type', $request->input('parent_type')],
                ['parent_id', $request->input('parent_id')],
            ])->get();
        } else {
            $images = Image::all();
        }

        if ($request->wantsJSON()) {
            return response()->json($images->toArray(), 200);
        } else {
            return view('page.image.index', ['images' => $images]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('page.image.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate data
        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,gif',
            'parent_type' => 'string',
            'parent_id' => 'integer',
        ]);

        $image = new Image;
        $image->user_id = Auth::user()->id;

        if ($request->has('parent_type') && $request->has('parent_id')) {
            $type = $request->input('parent_type');
            $id = intval($request->input('parent_id'));

            if ($type === 'designer') {
                $parent = Designer::find($id);
            } elseif ($type === 'place') {
                $parent = Place::find($id);
            } elseif ($type === 'country') {
                $parent = Country::find($id);
            } elseif ($type === 'city') {
                $parent = City::find($id);
            }

            if (Gate::allows('edit-page', $parent)) {
                $image->parent_type = $type;
                $image->parent_id = $id;
            }
        }

        $file = $request->file('image');

        if ($file->isValid()) {
            $image->mime_type = $file->getMimeType();
            $image->save();
            $image->saveFile($file);

            if ($request->wantsJSON()) {
                return response()->json($image->toArray(), 200);
            } else {
                return redirect()->route('image.show', ['id' => $image->id]);
            }
        } else {
            $error_message = 'Fail to upload image.';

            if ($request->wantsJSON()) {
                return response()->json(['image' => [$error_message]], 422);
            } else {
                return back()->withErrors(['image' => $error_message]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
