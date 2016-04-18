<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Input;

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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $image = new Image;
        $image->user_id = Auth::user()->id;

        if ($request->hasFile('image')) {

            $file = $request->file('image');
            $mime_type = $file->getMimeType();

            if ($file->isValid() && Image::isMimeTypeAllowed($mime_type)) {
                $image->mime_type = $mime_type;
                $image->save();
                $image->saveFile($file);
            } else {
                // TODO Error: file is invalid
            }

        } elseif ($request->has('url')) {

            $url = $request->input('url');

            if (Image::isYouTubeUrl($url)) {
                $image->mime_type = 'video/youtube';
                $image->external_url = $url;
                $image->save();
            } elseif (Image::isVimeoUrl($url)) {
                $image->mime_type = 'video/vimeo';
                $image->external_url = $url;
                $image->save();
            } else {
                // TODO Error: url is invalid
            }

        } else {
            // TODO Error: missing information
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
