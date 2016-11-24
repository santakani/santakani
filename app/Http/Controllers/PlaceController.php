<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ActivityLog;
use App\Http\Requests;
use App\Localization\Languages;
use App\City;
use App\Place;
use App\PlaceTranslation;
use App\Support\Random;

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

        if ($request->has('search')) {
            $words = explode(" ", $request->input('search'));
            $query->whereHas('translations', function ($sub_query) use ($words) {
                foreach ($words as $word) {
                    // If it is Chinese, use LIKE. Else, use full text index.
                    // http://www.regular-expressions.info/unicode.html#script
                    if (preg_match('/\p{Han}+/u', $word)) {
                        $sub_query->where(function ($q) use ($word) {
                            $q->where('name', 'like', '%'.$word.'%')->orWhere('content', 'like', '%'.$word.'%');
                        });
                    } else {
                        $sub_query->whereRaw('MATCH(name,content) AGAINST(? IN BOOLEAN MODE)', [$word.'*']);
                    }
                }
            });
        }

        if ($request->has('type')) {
            $query = $query->where('type', $request->input('type'));
        }

        if ($request->has('tag_id')) {
            $query = $query->whereHas('tags', function ($sub_query) use ($request) {
                $sub_query->where('id', $request->input('tag_id'));
            });
        }

        $query->with('image');

        $query->orderByRaw('RAND(' . Random::getUserSeed() . ')');

        $places = $query->paginate(24);

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

        ActivityLog::create([
            'action' => 'create',
            'message' => '<a href="'.$request->user()->url.'">'.htmlspecialchars($request->user()->name).
                         '</a> created place page <a href="'.$place->url.'">'.
                         htmlspecialchars($place->text('name')).'</a>.',
            'level' => 100,
            'target_type' => 'place',
            'target_id' => $place->id,
            'user_id' => $request->user()->id,
        ]);

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

        return view('pages.place.show', ['place' => $place]);
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

        if ($request->input('lock')) {
            if ($place->lock()) {
                return; // 200 OK
            } else {
                abort(423); // 423 Locked
            }
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
            'translations.*.name' => 'string|max:255',
            'translations.*.content' => 'string',
        ]);

        // Transfer ownership
        if ($request->has('user_id')) {
            if ($request->user()->can('transfer-place', $place)) {
                $old_user_id = $place->user_id;
                $place->transfer($request->input('user_id'));
                $new_user_id = $place->user_id;

                ActivityLog::create([
                    'action' => 'transfer',
                    'message' => '<a href="'.$request->user()->url.'">'.htmlspecialchars($request->user()->name).
                                '</a> transfered place page <a href="'.$place->url.'">'.
                                htmlspecialchars($place->text('name')).'</a> to <a href="'.$place->user->url.
                                '">'.htmlspecialchars($place->user->name).'</a>.',
                    'metadata' => json_encode([
                        'old_user_id' => $old_user_id,
                        'new_user_id' => $new_user_id,
                    ]),
                    'level' => 150,
                    'target_type' => 'place',
                    'target_id' => $place->id,
                    'user_id' => $request->user()->id,
                ]);

                return;
            } else {
                abort(403);
            }
        }

        $place->fill($request->all());

        $place->save();

        if ($request->has('translations')) {
            foreach ($request->input('translations') as $locale => $texts) {
                if (!Languages::has($locale)) {
                    continue;
                }

                $translation = PlaceTranslation::firstOrCreate([
                    'place_id' => $id,
                    'locale' => $locale,
                ]);

                $translation->update(app_array_filter($texts, ['name', 'content']));
            }
        }

        ActivityLog::create([
            'action' => 'edit',
            'message' => '<a href="'.$request->user()->url.'">'.htmlspecialchars($request->user()->name).
                         '</a> edited place page <a href="'.$place->url.'">'.
                         htmlspecialchars($place->text('name')).'</a>.',
            'level' => 100,
            'target_type' => 'place',
            'target_id' => $place->id,
            'user_id' => $request->user()->id,
        ]);
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
        $this->validate($request, [
            'action' => 'string|in:delete,restore,force_delete',
        ]);

        $place = Place::withTrashed()->find($id);

        if (empty($place)) {
            abort(404);
        }

        if ($request->user()->cannot('delete-place', $place)) {
            abort(403);
        }

        switch ($request->input('action')) {
            case 'restore':
                $place->restoreWithRelationships();

                ActivityLog::create([
                    'action' => 'restore',
                    'message' => '<a href="'.$request->user()->url.'">'.htmlspecialchars($request->user()->name).
                                '</a> restored place page <a href="'.$place->url.'">'.
                                htmlspecialchars($place->text('name')).'</a>.',
                    'level' => 150,
                    'target_type' => 'place',
                    'target_id' => $place->id,
                    'user_id' => $request->user()->id,
                ]);

                break;
            case 'force_delete':
                // Hard delete with related models
                ActivityLog::create([
                    'action' => 'delete',
                    'message' => '<a href="'.$request->user()->url.'">'.htmlspecialchars($request->user()->name).
                                '</a> deleted place page <a href="'.$place->url.'">'.
                                htmlspecialchars($place->text('name')).'</a>.',
                    'level' => 150,
                    'target_type' => 'place',
                    'target_id' => $place->id,
                    'user_id' => $request->user()->id,
                ]);

                $place->forceDeleteWithRelationships();

                break;
            default:
                // Soft delete with related models
                $place->deleteWithRelationships();

                ActivityLog::create([
                    'action' => 'trash',
                    'message' => '<a href="'.$request->user()->url.'">'.htmlspecialchars($request->user()->name).
                                '</a> trashed place page <a href="'.$place->url.'">'.
                                htmlspecialchars($place->text('name')).'</a>.',
                    'level' => 150,
                    'target_type' => 'place',
                    'target_id' => $place->id,
                    'user_id' => $request->user()->id,
                ]);
        }
    }
}
