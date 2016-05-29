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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->validate($request, [
            'city_id' => 'integer|exists:city,id',
        ]);

        if ($request->has('city_id')) {
            $city = City::find($request->has('city_id'));
            $places = Place::where('city_id', $city->id)->paginate(16);
        } elseif ( count( City::where('slug', 'helsinki')->get() ) ) {
            $city = City::where('slug', 'helsinki')->first();
            $places = Place::where('city_id', $city->id)->paginate(16);
        } else {
            $places = Place::paginate(16);
        }

        return view('page.place.index', [
            'body_class' => 'places',
            'active_nav' => 'place',
            'places' => $places,
            'city' => $city,
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
