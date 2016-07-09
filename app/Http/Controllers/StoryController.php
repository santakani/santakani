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

use App\Localization\Languages;

use App\Story;
use App\StoryTranslation;

/**
 * StoryController
 *
 * RESTful APIs for story resource.
 *
 * @author Guo Yunhe <guoyunhebrave@gmail.com>
 * @see https://github.com/santakani/santakani.com/wiki/Story
 */
class StoryController extends Controller
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
            'tag_id' => 'integer|exists:tag,id',
        ]);

        if ($request->has('tag_id')) {
            $stories = Story::whereHas('tags', function ($query) use ($request){
                $query->where('id', $request->input('tag_id'));
            })->orderBy('created_at', 'desc')->paginate(12);
        } else {
            $stories = Story::orderBy('created_at', 'desc')->paginate(12);
        }

        return view('pages.story.index', [
            'stories' => $stories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.story.create');
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
            'title' => 'required|string|max:255',
        ]);

        $story = new Story();
        $story->user_id = $request->user()->id;
        $story->save();

        $translation = new StoryTranslation();
        $translation->story_id = $story->id;
        $translation->locale = 'en';
        $translation->title = $request->input('title');
        $translation->save();

        return redirect()->action('StoryController@edit', [$story]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $story = Story::find($id);

        if (empty($story)) {
            abort(404);
        }

        $story->load('translations');

        return view('pages.story.show', [
            'story' => $story,
            'can_edit' => Gate::allows('edit-page', $story),
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
        $story = Story::find($id);

        if (empty($story)) {
            abort(404);
        }

        if (Gate::denies('edit-page', $story)) {
            abort(403);
        }

        $story->load('translations');

        return view('pages.story.edit', [
            'story' => $story,
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
        $story = Story::find($id);

        if (empty($story)) {
            abort(404);
        }

        if ($request->user()->cannot('edit-story', $story)) {
            abort(403);
        }

        $this->validate($request, [
            'image_id' => 'integer|exists:image,id',
            'user_id' => 'integer|exists:user,id',
            'tag_ids.*' => 'integer|exists:tag,id',
            'translations' => 'array',
            'translations.*.title' => 'string|max:255',
            'translations.*.content' => 'string',
        ]);

        $story->update(app_array_filter($request->all(), ['image_id', 'tag_ids']));

        // TODO transfer story page to another user...

        if ($request->has('translations')) {
            foreach ($request->input('translations') as $locale => $texts) {
                if ( empty($texts['title']) && empty($texts['content']) ) {
                    continue;
                }

                if (!in_array($locale, Languages::all())) {
                    continue;
                }

                $translation = StoryTranslation::firstOrCreate([
                    'story_id' => $id,
                    'locale' => $locale,
                ]);

                $translation->update(app_array_filter($texts, ['title', 'content']));
            }
        }
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
        $story = Story::find($id);

        if (empty($story)) {
            abort(404);
        }

        if (Gate::denies('edit-page', $story)) {
            abort(403);
        }

        if ($request->has('force_delete')) {
            $story->images()->forceDelete();
            $story->forceDelete();
        } elseif ($request->has('restore')) {
            $story->restore();
        } else {
            $story->delete();
        }
    }
}
