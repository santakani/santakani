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

use App\Http\Requests;
use App\Designer;
use App\Image;
use Illuminate\Http\Request;
use Imagick;

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
            $images = Image::where('user_id', $request->user()->id)->get();
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
            return view('pages.image.index', ['images' => $images]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,gif',
            'parent_type' => 'string|in:city,country,design,designer,place,story,tag',
            'parent_id' => 'integer',
        ]);

        if (!$request->file('image')->isValid()) {
            $error_message = 'Fail to upload image.';
            return response()->json(['image' => [$error_message]], 422);
        }

        $file_path = $request->file('image')->getPathName();

        $image_meta = getimagesize($file_path);

        $image = Image::create([
            'mime_type' => $image_meta['mime'],
            'width' => $image_meta[0],
            'height' => $image_meta[1],
        ]);

        $image->user_id = $request->user()->id;

        if ($request->has('parent_type') && $request->has('parent_id')) {
            $image->parent_type = $request->input('parent_type');
            $image->parent_id = $request->input('parent_id');

            if ($request->user()->cannot('edit-'.$image->parent_type, $image->parent)) {
                $image->parent_type = null;
                $image->parent_id = null;
            }
        }

        $image->save();

        $image->saveFile($file_path);

        return response()->json($image->toArray(), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $image = Image::find($id);
        if (empty($image)) {
            abort(404);
        }
        return view('pages.image.show', ['image' => $image]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $image = Image::find($id);

        if (empty($image)) {
            abort(404);
        }

        if ($request->user()->cannot('delete-image', $image)) {
            abort(403);
        }

        $image->deleteWithFiles();
    }
}
