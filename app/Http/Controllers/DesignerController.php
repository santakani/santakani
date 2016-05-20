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

use Gate;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

use App\Http\Requests;
use App\City;
use App\CityTranslation;
use App\Country;
use App\CountryTranslation;
use App\Designer;
use App\DesignerTranslation;
use App\Image;

/**
 * DesignerController
 *
 * Provide RESTful APIs for designer resources.
 *
 * @author Guo Yunhe <guoyunhebrave@gmail.com>
 * @see https://github.com/santakani/santakani.com/wiki/Designer
 */
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
        $this->middleware('safetext', ['only' => ['store','update']]);
        $this->middleware('trim');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $designers = Designer::with('translations')->get();

        return view('page.designer.index', [
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
        return view('page.designer.create');
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

        if ($request->has('email')) {
            $designer->email = $request->input('email');
        }
        if ($request->has('country')) {
            $designer->country_id = intval($request->input('country'));
        }
        if ($request->has('city')) {
            $designer->city_id = intval($request->input('city'));
        }
        $designer->user_id = $request->user()->id;

        $designer->save();

        $translation->designer_id = $designer->id;
        $translation->locale = 'en';
        if ($request->has('name')) {
            $translation->name = $request->input('name');
        }
        if ($request->has('tagline')) {
            $translation->tagline = $request->input('tagline');
        }

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

        $designer->load('translations');

        return view('page.designer.show', [
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

        return view('page.designer.edit', ['designer' => $designer]);
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

        $translation = $designer->translations()->where('locale', 'en')->first();

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

        foreach (['name', 'tagline', 'content'] as $key) {
            if ($request->has($key)) {
                // Not empty, fill the value
                $translation->$key = $request->input($key);
            } elseif ($request->exists($key)) {
                // Empty, set null.
                $translation->$key = null;
            } else {
                // Not provided, untouch properties.
            }
        }

        $translation->save();

        foreach (['image', 'country', 'city'] as $key) {
            if ($request->has($key)) {
                // Not empty, fill the value
                $designer[$key.'_id'] = intval($request->input($key));
            } elseif ($request->exists($key)) {
                // Empty, set null.
                $designer[$key.'_id'] = null;
            } else {
                // Not provided, untouch properties.
            }
        }

        foreach (['email', 'facebook', 'twitter', 'google_plus', 'instagram'] as $key) {
            if ($request->has($key)) {
                // Not empty, fill the value
                $designer->$key = $request->input($key);
            } elseif ($request->exists($key)) {
                // Empty, set null.
                $designer->$key = null;
            } else {
                // Not provided, untouch properties.
            }
        }

        if ($request->has('tags')) {
            $designer->tag_ids = array_map('intval',$request->input('tags'));
        }

        $designer->save();
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
