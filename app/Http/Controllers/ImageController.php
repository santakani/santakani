<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use Illuminate\Http\Request;
use Imagick;

use App\Http\Requests;
use App\Designer;
use App\Image;


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
        $this->middleware('trim', ['only' => ['store','update']]);
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
            'user' => 'integer|exists:user,id',
            'designer' => 'integer|exists:designer,id',
            'place' => 'integer|exists:place,id',
        ]);

        if ($request->has('user')) {
            $images = Image::where('user_id', $request->user)->get();
        } elseif ($request->has('designer')) {
            $images = Designer::find($request->designer)->images;
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
            'image' => 'required_without_all:url|image|mimes:jpeg,png,gif',
            'url' => 'required_without_all:image|url',
        ]);

        $image = new Image;
        $image->user_id = Auth::user()->id;

        $error_messages = [];

        if ($request->hasFile('image')) {

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

        } elseif ($request->has('url')) {

            $url = $request->input('url');

            if (Image::checkYouTubeUrl($url)) {
                $image->mime_type = 'video/youtube';
                $image->external_url = $url;
                $image->save();
            } elseif (Image::checkVimeoUrl($url)) {
                $image->mime_type = 'video/vimeo';
                $image->external_url = $url;
                $image->save();
            } else {
                $error_message = 'The URL is not a valid YouTube/Vimeo URL.';

                if ($request->wantsJSON()) {
                    return response()->json(['url' => [$error_message]], 422);
                } else {
                    return back()->withErrors(['url' => [$error_message]]);
                }
            }

            if ($request->wantsJSON()) {
                return response()->json($image->toArray(), 200);
            } else {
                return redirect()->route('image.show', ['id' => $image->id]);
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
