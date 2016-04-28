<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

use Gate;

use App\Http\Requests;
use App\Designer;
use App\DesignerTranslation;

class DesignerController extends Controller
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
        $designers = Designer::all();
        return view('stories', [
            'body_class' => 'stories',
            'active_nav' => 'story',
            'designers' => $designers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * Any logged-in users can create designer page.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('designer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * Any logged-in users can create designer page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate data
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'tagline' => 'string|max:255',
            'email' => 'email|max:255',
            'country' => 'integer|exists:country,id',
            'city' => 'integer|exists:city,id',
        ]);

        // Save models
        $designer = new Designer();
        $translation = new DesignerTranslation();

        $designer->email = $request->input('email');
        $designer->country_id = $request->input('country');
        $designer->city_id = $request->input('city');
        $designer->user_id = $request->user()->id;

        $designer->save();

        $translation->designer_id = $designer->id;
        $translation->locale = 'en';
        $translation->name = $request->input('name');
        $translation->tagline = $request->input('tagline');

        $translation->save();

        // Redirect to edit page
        return redirect()->action('DesignerController@edit', [$designer]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $designer = Designer::find($id);

        if (empty($designer)) {
            abort(404);
        }

        return view('designer.show', [
            'designer' => $designer,
            'can_edit' => Gate::allows('edit-page', $designer),
            'can_translate' => Gate::allows('translate-page', $designer),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * Only owner and admin, editor can edit designer page.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $designer = Designer::find($id);

        if (empty($designer)) {
            abort(404);
        }

        // Check permission
        if (Gate::denies('edit-page', $designer)) {
            abort(403);
        }

        return view('designer.edit', ['designer' => $designer]);
    }

    /**
     * Update the specified resource in storage.
     *
     * Only owner and admin, editor can edit designer page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $designer = Designer::find($id);

        $translation = DesignerTranslation::where([
            ['designer_id', $id],
            ['locale', 'en'],
        ])->first();

        if (empty($designer)) {
            abort(404);
        }

        // Check permission
        if (Gate::denies('edit-page', $designer)) {
            abort(403);
        }

        // Validate data
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'tagline' => 'string|max:255',
            'content' => 'string',
            'image' => 'integer|exists:image,id',
            'images.*' => 'integer|exists:image,id',
            'country' => 'integer|exists:country,id',
            'city' => 'integer|exists:city,id',
            'tags.*' => 'integer|exists:tag,id',
            'email' => 'email|max:255',
            'facebook' => 'url|max:255',
            'twitter' => 'url|max:255',
            'google_plus' => 'url|max:255',
            'instagram' => 'url|max:255',
        ]);

        // Save models
        if ($request->input('image')) {
            $designer->image_id = $request->input('image');
        }
        if ($request->input('country')) {
            $designer->country_id = $request->input('country');
        }
        if ($request->input('city')) {
            $designer->city_id = $request->input('city');
        }
        $designer->email = $request->input('email');
        $designer->facebook = $request->input('facebook');
        $designer->twitter = $request->input('twitter');
        $designer->google_plus = $request->input('google_plus');
        $designer->instagram = $request->input('instagram');

        $designer->save();

        $translation->name = $request->input('name');
        $translation->tagline = $request->input('tagline');
        // TODO Secure HTML input http://htmlpurifier.org/
        $translation->content = $request->input('content');

        $translation->save();

        // TODO Save tags

        // TODO Save images
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $designer = Designer::find($id);

        if (empty($designer)) {
            abort(404);
        }

        // Check permission
        if (Gate::denies('edit-page', $designer)) {
            abort(403);
        }

        // TODO Delete model from database
    }
}
