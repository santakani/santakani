<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Imagick;

use App\Http\Requests;
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'image' => 'required_without_all:url|image',
            'url' => 'required_without_all:image|url',
        ]);

        $image = new Image;
        $image->user_id = Auth::user()->id;

        if ($request->hasFile('image')) {

            $file = $request->file('image');
            $mime_type = $file->getMimeType();

            if ($file->isValid() && Image::checkMimeType($mime_type)) {
                $image->mime_type = $mime_type;
                $image->save();
                $image->saveFile($file);

                if ($request->wantsJSON()) {
                    return response()->json([
                        'id' => $image->id,
                        'mime_type' => $image->mime_type,
                        'width' => $image->width,
                        'height' => $image->height,
                        'url' => [
                            'large' => $image->getUrl('large'),
                            'medium' => $image->getUrl('medium'),
                            'small' => $image->getUrl('small'),
                            'thumb' => $image->getUrl('thumb'),
                            'smallThumb' => $image->getUrl('thumb-small'),
                        ],
                    ], 200);
                }
            } else {
                $error_message = 'Invalid file. Only JPEG, PNG, GIF images are allowed.';

                if ($request->wantsJSON()) {
                    return response()->json(['image' => $error_message], 400);
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
                    return response()->json(['url' => $error_message], 400);
                } else {
                    return back()->withErrors(['url' => $error_message]);
                }
            }

            if ($request->wantsJSON()) {
                return response()->json([
                    'id' => $image->id,
                    'mime_type' => $image->mime_type,
                    'url' => $image->external_url,
                ], 200);
            }

        } else {
            $error_message = 'No image file or YouTube/Vimeo URL found.';

            if ($request->wantsJSON()) {
                return response()->json(['url' => $error_message], 400);
            } else {
                return back()->withErrors(['url' => $error_message]);
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
