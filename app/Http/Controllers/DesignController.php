<?php

namespace App\Http\Controllers;

use App\ActivityLog;
use App\Design;
use App\Designer;
use App\DesignTranslation;
use App\Http\Requests;
use App\Localization\Currencies;
use App\Localization\Languages;
use App\Support\Random;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

class DesignController extends Controller
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

        $query = Design::query();

        if ($request->has('search')) {
            // Escape some special SQL characters. Not sure if it is safe enough.
            $search = str_replace(['@', '*', '%', '"', "'"], ' ', $request->input('search'));
            // array_filter() remove empty string in $words array.
            $words = array_filter(explode(" ", $search));

            $query->whereHas('translations', function ($sub_query) use ($words) {
                foreach ($words as $word) {
                    // If it is Chinese, use LIKE. Else, use full text index.
                    // http://www.regular-expressions.info/unicode.html#script
                    if (preg_match('/\p{Han}+/u', $word)) {
                        $sub_query->where(function ($q) use ($word) {
                            $q->where('name', 'like', '%'.$word.'%')
                              ->orWhere('content', 'like', '%'.$word.'%');
                        });
                    } else {
                        $sub_query->whereRaw('MATCH(name,content) AGAINST(? IN BOOLEAN MODE)', [$word.'*']);
                    }
                }
            });
        }

        if ($request->has('tag_id')) {
            $query->whereHas('tags', function ($sub_query) use ($request){
                $sub_query->where('id', $request->input('tag_id'));
            });
        }

        $query->whereNotNull('image_id');

        $query->orderByRaw('RAND(' . Random::getUserSeed() . ')');

        $designs = $query->paginate(12);

        return view('pages.design.index', [
            'designs' => $designs
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'designer_id' => 'integer|exists:designer,id',
        ]);

        $data = [];

        if ($request->has('designer_id')) {
            $data['designer'] = Designer::find($request->input('designer_id'));
        }

        return view('pages.design.create', $data);
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
            'designer_id' => 'required|integer|exists:designer,id',
            'name' => 'required|string|max:255',
        ]);

        $design = new Design();
        $design->designer_id = $request->input('designer_id');
        $design->user_id = $request->user()->id;
        $design->save();

        $translation = new DesignTranslation();
        $translation->design_id = $design->id;
        $translation->locale = 'en';
        $translation->name = $request->input('name');
        $translation->save();

        ActivityLog::create([
            'action' => 'create',
            'message' => '<a href="'.$request->user()->url.'">'.htmlspecialchars($request->user()->name).
                         '</a> created design page <a href="'.$design->url.'">'.
                         htmlspecialchars($design->text('name')).'</a>.',
            'level' => 100,
            'target_type' => 'design',
            'target_id' => $design->id,
            'user_id' => $request->user()->id,
        ]);

        return redirect()->action('DesignController@edit', [$design]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $design = Design::find($id);

        if (empty($design)) {
            abort(404);
        }

        return view('pages.design.show', [
            'design' => $design,
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
    public function edit($id, Request $request)
    {
        $design = Design::find($id);

        if (empty($design)) {
            abort(404);
        }

        if ($request->user()->cannot('edit-design', $design)) {
            abort(403);
        }

        return view('pages.design.edit', ['design' => $design]);
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
        $design = Design::find($id);

        if (empty($design)) {
            abort(404);
        }

        if ($request->user()->cannot('edit-design', $design)) {
            abort(403);
        }

        if ($request->input('lock')) {
            if ($design->lock()) {
                return; // 200 OK
            } else {
                abort(423); // 423 Locked
            }
        }

        $this->validate($request, [
            'image_id' => 'integer|exists:image,id',
            'gallery_image_ids.*' => 'integer|exists:image,id',
            'designer_id' => 'integer|exists:designer,id',
            'user_id' => 'integer|exists:user,id',
            'tag_ids.*' => 'integer|exists:tag,id',
            'price' => 'numeric|between:0.01,999999.99',
            'currency' => 'required_with:price|' . Currencies::validator(),
            'webshop' => 'url|max:255',
            'translations.*.name' => 'string|max:255',
        ]);

        if ($request->has('user_id')) {
            if ($request->user()->can('transfer-design', $design)) {
                $old_user = $design->user;
                $design->transfer($request->input('user_id'));
                $new_user = \App\User::find($request->input('user_id'));

                ActivityLog::create([
                    'action' => 'transfer',
                    'message' => '<a href="'.$request->user()->url.'">'.htmlspecialchars($request->user()->name).
                                '</a> transfered design page <a href="'.$design->url.'">'.
                                htmlspecialchars($design->text('name')).'</a> from <a href="'.
                                $old_user->url.'">'.htmlspecialchars($old_user->name).
                                '</a> to <a href="'.$new_user->url.
                                '">'.htmlspecialchars($new_user->name).'</a>.',
                    'metadata' => json_encode([
                        'old_user_id' => $old_user->id,
                        'new_user_id' => $new_user->id,
                    ]),
                    'level' => 150,
                    'target_type' => 'design',
                    'target_id' => $design->id,
                    'user_id' => $request->user()->id,
                ]);

                return;
            } else {
                abort(403);
            }
        }

        $design->fill($request->all());
        $design->updateEuroPrice();

        $design->save();

        if ($request->has('translations')) {
            foreach ($request->input('translations') as $locale => $texts) {
                if (!Languages::has($locale)) {
                    continue;
                }

                $translation = DesignTranslation::where([
                    ['design_id', $design->id],
                    ['locale', $locale],
                ])->first();

                if (!count($translation)) {
                    $translation = new DesignTranslation();
                    $translation->design_id = $design->id;
                    $translation->locale = $locale;
                }

                $translation->fill($texts);
                $translation->save();
            }
        }

        ActivityLog::create([
            'action' => 'edit',
            'message' => '<a href="'.$request->user()->url.'">'.htmlspecialchars($request->user()->name).
                         '</a> edited design page <a href="'.$design->url.'">'.
                         htmlspecialchars($design->text('name')).'</a>.',
            'level' => 100,
            'target_type' => 'design',
            'target_id' => $design->id,
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

        $design = Design::withTrashed()->find($id);

        if (empty($design)) {
            abort(404);
        }

        if ($request->user()->cannot('delete-design', $design)) {
            abort(403);
        }

        switch ($request->input('action')) {
            case 'restore':
                $design->restoreWithRelationships();

                ActivityLog::create([
                    'action' => 'restore',
                    'message' => '<a href="'.$request->user()->url.'">'.htmlspecialchars($request->user()->name).
                                '</a> restored design page <a href="'.$design->url.'">'.
                                htmlspecialchars($design->text('name')).'</a>.',
                    'level' => 150,
                    'target_type' => 'design',
                    'target_id' => $design->id,
                    'user_id' => $request->user()->id,
                ]);

                break;
            case 'force_delete':
                // Hard delete with related models
                ActivityLog::create([
                    'action' => 'delete',
                    'message' => '<a href="'.$request->user()->url.'">'.htmlspecialchars($request->user()->name).
                                '</a> deleted design page <a href="'.$design->url.'">'.
                                htmlspecialchars($design->text('name')).'</a>.',
                    'level' => 150,
                    'target_type' => 'design',
                    'target_id' => $design->id,
                    'user_id' => $request->user()->id,
                ]);

                $design->forceDeleteWithRelationships();

                break;
            default:
                // Soft delete with related models
                $design->deleteWithRelationships();

                ActivityLog::create([
                    'action' => 'trash',
                    'message' => '<a href="'.$request->user()->url.'">'.htmlspecialchars($request->user()->name).
                                '</a> trashed design page <a href="'.$design->url.'">'.
                                htmlspecialchars($design->text('name')).'</a>.',
                    'level' => 150,
                    'target_type' => 'design',
                    'target_id' => $design->id,
                    'user_id' => $request->user()->id,
                ]);
        }
    }
}
