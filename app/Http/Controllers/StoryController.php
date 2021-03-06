<?php

/*
 * This file is part of Santakani
 *
 * (c) Guo Yunhe <guoyunhebrave@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Http\Controllers;

use App;
use App\ActivityLog;
use App\Localization\Languages;
use App\Story;
use App\StoryTranslation;
use Carbon\Carbon;
use Illuminate\Http\Request;

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

        $query = Story::query();

        // Must have translation of current locale or English
        $query->whereHas('translations', function ($sub_query) {
            $sub_query->whereIn('locale', ['en', App::getLocale()])->whereNotNull('title');
        });

        if ($request->has('tag_id')) {
            $query->whereHas('tags', function ($sub_query) use ($request){
                $sub_query->where('id', $request->input('tag_id'));
            });
        }

        $stories = $query->whereNotNull('published_at')->orderBy('published_at', 'desc')->paginate(12);

        if (!$request->has('page') || $request->input('page') == 1) {
            $drafts = Story::whereNull('published_at')->get();

            return view('pages.story.index', [
                'stories' => $stories,
                'drafts' => $drafts,
            ]);
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

        ActivityLog::create([
            'action' => 'create',
            'message' => '<a href="'.$request->user()->url.'">'.htmlspecialchars($request->user()->name).
                         '</a> created story <a href="'.$story->url.'">'.
                         htmlspecialchars($story->text('title')).'</a>.',
            'level' => 100,
            'target_type' => 'story',
            'target_id' => $story->id,
            'user_id' => $request->user()->id,
        ]);

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

        return view('pages.story.show', ['story' => $story]);
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
        $story = Story::find($id);

        if (empty($story)) {
            abort(404);
        }

        if ($request->user()->cannot('edit-story', $story)) {
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

        if ($request->input('lock')) {
            if ($story->lock()) {
                return; // 200 OK
            } else {
                abort(423); // 423 Locked
            }
        }

        $this->validate($request, [
            'image_id' => 'integer|nullable|exists:image,id',
            'user_id' => 'integer|nullable|exists:user,id',
            'tag_ids.*' => 'integer|nullable|exists:tag,id',
            'translations' => 'array',
            'translations.*' => 'array',
            'translations.*.title' => 'string|nullable|max:255',
            'translations.*.content' => 'string|nullable',
            'editor_rating' => 'integer|max:100|min:-100',
            'status' => 'in:draft,published',
        ]);

        // Editor rating
        if ($request->has('editor_rating')) {
            if ($request->user()->can('editor-rating')) {
                $story->editor_rating = $request->input('editor_rating');
                $story->save();
                return;
            } else {
                abort(403);
            }
        }

        $story->image_id = $request->input('image_id');

        if ($request->input('status') === 'draft' && !empty($story->published_at)) {
            $story->published_at = null;
        } elseif ($request->input('status') === 'published' && empty($story->published_at)) {
            $story->published_at = Carbon::now();
        }

        $story->save();

        if ($request->has('tag_ids')) {
            $story->tag_ids = $request->input('tag_ids');
        }

        if ($request->has('translations')) {
            foreach ($request->input('translations') as $locale => $texts) {
                if (!Languages::has($locale)) {
                    continue;
                }

                $translation = StoryTranslation::firstOrCreate([
                    'story_id' => $id,
                    'locale' => $locale,
                ]);

                $translation->update(app_array_filter($texts, ['title', 'content']));
            }
        }

        ActivityLog::create([
            'action' => 'edit',
            'message' => '<a href="'.$request->user()->url.'">'.htmlspecialchars($request->user()->name).
                         '</a> edited story <a href="'.$story->url.'">'.
                         htmlspecialchars($story->text('title')).'</a>.',
            'level' => 100,
            'target_type' => 'story',
            'target_id' => $story->id,
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

        $story = Story::withTrashed()->find($id);

        if (empty($story)) {
            abort(404);
        }

        if ($request->user()->cannot('delete-story', $story)) {
            abort(403);
        }

        switch ($request->input('action')) {
            case 'restore':
                $story->restoreWithRelationships();

                ActivityLog::create([
                    'action' => 'restore',
                    'message' => '<a href="'.$request->user()->url.'">'.htmlspecialchars($request->user()->name).
                                '</a> restored story <a href="'.$story->url.'">'.
                                htmlspecialchars($story->text('title')).'</a>.',
                    'level' => 150,
                    'target_type' => 'story',
                    'target_id' => $story->id,
                    'user_id' => $request->user()->id,
                ]);

                break;
            case 'force_delete':
                // Hard delete with related models
                ActivityLog::create([
                    'action' => 'delete',
                    'message' => '<a href="'.$request->user()->url.'">'.htmlspecialchars($request->user()->name).
                                '</a> deleted story <a href="'.$story->url.'">'.
                                htmlspecialchars($story->text('title')).'</a>.',
                    'level' => 150,
                    'target_type' => 'story',
                    'target_id' => $story->id,
                    'user_id' => $request->user()->id,
                ]);

                $story->forceDeleteWithRelationships();

                break;
            default:
                // Soft delete with related models
                $story->deleteWithRelationships();

                ActivityLog::create([
                    'action' => 'trash',
                    'message' => '<a href="'.$request->user()->url.'">'.htmlspecialchars($request->user()->name).
                                '</a> trashed story <a href="'.$story->url.'">'.
                                htmlspecialchars($story->text('title')).'</a>.',
                    'level' => 150,
                    'target_type' => 'story',
                    'target_id' => $story->id,
                    'user_id' => $request->user()->id,
                ]);
        }
    }
}
