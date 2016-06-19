<?php

namespace App\Http\Controllers;

use Gate;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\City;
use App\Place;
use App\PlaceTranslation;

class PlaceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','show']]);
        $this->middleware('safetext', ['only' => ['store','update']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->validate($request, [
            'city_id' => 'integer|exists:city,id',
            'type' => 'string|in:' . implode(',', Place::types()),
        ]);

        if ($request->has('city_id')) {
            $city = City::find($request->input('city_id'));
        } else {
            $city = City::where('geoname_id', 658225)->first();
            if (!count($city)) {
                $city = City::first();
            }
        }

        if ($request->has('type')) {
            $places = Place::where([
                ['city_id', $city->id],
                ['type', $request->input('type')],
            ])->paginate(24);
        } else {
            $places = Place::where('city_id', $city->id)->paginate(24);
        }



        return view('page.place.index', [
            'places' => $places,
            'city' => $city,
            'type' => $request->input('type'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('page.place.create');
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
            'type' => 'required|string|in:' . implode(',', Place::types()),
            'city_id' => 'required|integer|exists:city,id',
            'address' => 'required|string|max:255',
            'email' => 'email|max:255',
            'name' => 'required|string|max:255',
        ]);

        $place = new Place($request->only(['type', 'address', 'city_id', 'email']));
        $place->user_id = $request->user()->id;
        $place->save();

        $translation = new PlaceTranslation($request->only(['name']));
        $translation->place_id = $place->id;
        $translation->locale = 'en';
        $translation->save();

        return redirect()->action('PlaceController@edit', [$place]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $place = Place::find($id);

        if (empty($place)) {
            abort(404);
        }

        $place->load('translations');

        return view('page.place.show', [
            'place' => $place,
            'can_edit' => Gate::allows('edit-page', $place),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $place = Place::find($id);

        if (empty($place)) {
            abort(404);
        }

        // Check permission
        if (Gate::denies('edit-page', $place)) {
            abort(403);
        }

        return view('page.place.edit', ['place' => $place]);
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
        $place = Place::find($id);

        $translation = $place->translations()->where('locale', 'en')->first();

        if (empty($place)) {
            abort(404);
        }

        // Check permission
        if (Gate::denies('edit-page', $place)) {
            abort(403);
        }

        // Validate data
        $this->validate($request, [
            'name' => 'string|max:255',
            'content' => 'string',
            'type' => 'string|in:' . implode(',', Place::types()),
            'image_id' => 'integer|exists:image,id',
            'gallery_image_ids.*' => 'integer|exists:image,id',
            'city_id' => 'integer|exists:city,id',
            'address' => 'string|max:255',
            'latitude' => 'numeric',
            'longitude' => 'numeric',
            'tag_ids.*' => 'integer|exists:tag,id',
            'email' => 'email|max:255',
            'phone' => 'string|max:255',
            'website' => 'url|max:255',
            'facebook' => 'url|max:255',
            'google_plus' => 'url|max:255',
        ]);

        foreach (['name', 'content'] as $key) {
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

        // Keys directly filled into designer model
        $keys = [
            'type', 'city_id', 'image_id', 'address', 'latitude', 'longitude',
            'email', 'phone', 'website', 'facebook', 'google_plus',
            'gallery_image_ids', 'tag_ids'
        ];

        foreach ($keys as $key) {
            if ($request->has($key)) {
                // Not empty, fill the value
                $place->$key = $request->input($key);
            } elseif ($request->exists($key)) {
                // Empty, set null.
                $place->$key = null;
            } else {
                // Not provided, untouch properties.
            }
        }

        $place->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $place = Place::find($id);

        if (empty($place)) {
            abort(404);
        }

        if (Gate::denies('edit-page', $place)) {
            abort(403);
        }

        if ($request->has('force_delete')) {
            if ($request->has('with_images')) {
                $place->images()->forceDelete();
            }
            $place->forceDelete();
        } elseif ($request->has('restore')) {
            $place->restore();
        } else {
            $place->delete();
        }
    }
}
