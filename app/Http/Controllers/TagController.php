<?php

namespace App\Http\Controllers;

use DB;
use Gate;

use Illuminate\Http\Request;

use App\Http\Requests;

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
            })->paginate(15);

        } else {
            $tags = Tag::paginate(15);

        }

        if ($request->wantsJSON()) {
            return response()->json($tags->toArray(), 200);
        } else {
            return view('page.tag.index', ['tags' => $tags]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('page.tag.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $tag = Tag::find($id);

        if (empty($tag)) {
            abort(404);
        }

        if (Gate::denies('edit-page', $tag)) {
            abort(403);
        }

        $tag->load('translations');

        return view('page.tag.edit', [
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
            'translations.*.name' => 'string',
            'translations.*.alias' => 'string',
            'translations.*.description' => 'string',
        ]);

        $tag->update($request->only(['level', 'image_id']));

        if ($request->has('translations') && is_array($request->input('translations'))) {
            foreach ($request->input('translations') as $locale => $texts) {
                if ( empty($texts['name']) && empty($texts['alias']) && empty($texts['description']) ) {
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
    public function destroy($id)
    {
        //
    }
}
