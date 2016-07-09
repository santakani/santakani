<?php

namespace App\Http\Controllers;

use Gate;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Localization\Languages;
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
            'tag_id' => 'integer|exists:tag,id',
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

        $query = Place::where('city_id', $city->id);

        if ($request->has('type')) {
            $query = $query->where('type', $request->input('type'));
        }

        if ($request->has('tag_id')) {
            $query = $query->whereHas('tags', function ($sub_query) use ($request) {
                $sub_query->where('id', $request->input('tag_id'));
            });
        }

        $places = $query->orderBy('like_count', 'desc')->paginate(24);

        return view('pages.place.index', [
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
        return view('pages.place.create');
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

        return view('pages.place.show', [
            'place' => $place,
            'can_edit' => Gate::allows('edit-page', $place),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $place = Place::find($id);

        if (empty($place)) {
            abort(404);
        }

        if ($request->user()->cannot('edit-place', $place)) {
            abort(403);
        }

        return view('pages.place.edit', ['place' => $place]);
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

        if (empty($place)) {
            abort(404);
        }

        if ($request->user()->cannot('edit-place', $place)) {
            abort(403);
        }

        // Validate data
        $this->validate($request, [
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
            'translations.*.name' => 'string|max:255',
            'translations.*.content' => 'string',
        ]);

        $place->update(app_array_filter($request->all(), [
            'type', 'city_id', 'image_id', 'address', 'latitude', 'longitude',
            'email', 'phone', 'website', 'facebook', 'google_plus',
            'gallery_image_ids', 'tag_ids'
        ]));

        // TODO transfer designer page to another user...

        if ($request->has('translations')) {
            foreach ($request->input('translations') as $locale => $texts) {
                if ( empty($texts['name']) && empty($texts['content']) ) {
                    continue;
                }

                if (!in_array($locale, Languages::all())) {
                    continue;
                }

                $translation = PlaceTranslation::firstOrCreate([
                    'place_id' => $id,
                    'locale' => $locale,
                ]);

                $translation->update(app_array_filter($texts, ['name', 'content']));
            }
        }
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
