<?php

namespace App\Http\Controllers;

use DB;
use Gate;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Localization\Languages;
use App\Tag;
use App\TagTranslation;

class TagController extends Controller
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
            'search' => 'string|max:20',
        ]);

        if ($request->has('search')) {
            $search = $request->input('search');

            $tags = Tag::whereHas('translations', function ($query) use ($search) {
                $query->where('name', 'like', $search . '%');
            })->paginate(24);

        } else {
            $tags = Tag::paginate(24);
        }

        if ($request->wantsJSON()) {
            return response()->json($tags->toArray(), 200);
        } else {
            return view('pages.tag.index', ['tags' => $tags]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.tag.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->user()->cannot('create-tag')) {
            abort(403);
        }

        $this->validate($request, [
            'level' => 'required|integer|between:0,255',
            'name' => 'required|string|max:255',
        ]);

        $tag = Tag::create($request->only(['level']));

        $translation = TagTranslation::create([
            'tag_id' => $tag->id,
            'locale' => 'en',
            'name' => $request->input('name'),
        ]);

        return redirect()->action('TagController@edit', [$tag]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tag = Tag::find($id);

        if (empty($tag)) {
            abort(404);
        }

        $designers = $tag->designers()->orderBy('id', 'desc')->take(6)->get();
        $places = $tag->places()->orderBy('id', 'desc')->take(6)->get();
        $stories = $tag->stories()->orderBy('id', 'desc')->take(6)->get();

        return view('pages.tag.show', [
            'tag' => $tag,
            'designers' => $designers,
            'places' => $places,
            'stories' => $stories,
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
        $tag = Tag::find($id);

        if (empty($tag)) {
            abort(404);
        }

        if (Gate::denies('edit-page', $tag)) {
            abort(403);
        }

        $tag->load('translations');

        return view('pages.tag.edit', [
            'tag' => $tag,
        ]);
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
        $tag = Tag::find($id);

        if (empty($tag)) {
            abort(404);
        }

        if (Gate::denies('edit-page', $tag)) {
            abort(403);
        }

        $this->validate($request, [
            'level' => 'integer|between:0,255',
            'image_id' => 'integer|exists:image,id',
            'translations' => 'array',
            'translations.*.name' => 'string|max:255',
            'translations.*.alias' => 'string|max:255',
            'translations.*.description' => 'string|max:255',
        ]);

        $tag->update($request->only(['level', 'image_id']));

        if ($request->has('translations') && is_array($request->input('translations'))) {
            foreach ($request->input('translations') as $locale => $texts) {
                if (!Languages::has($locale)) {
                    continue;
                }

                $translation = TagTranslation::firstOrCreate([
                    'tag_id' => $id,
                    'locale' => $locale,
                ]);

                $translation->update(array_only($texts, ['name', 'alias', 'description']));
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
        $tag = Tag::find($id);

        if (empty($tag)) {
            abort(404);
        }

        if (Gate::denies('edit-page', $tag)) {
            abort(403);
        }

        if ($request->has('force_delete')) {
            $tag->forceDelete();
        } elseif ($request->has('restore')) {
            $tag->restore();
        } else {
            $tag->delete();
        }
    }
}
