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

use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use App\ActivityLog;
use App\Address;
use App\Designer;
use App\DesignerTranslation;
use App\Http\Requests;
use App\Localization\Languages;
use App\Support\Random;

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

        $query = Designer::query();

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
                              ->orWhere('tagline', 'like', '%'.$word.'%')
                              ->orWhere('content', 'like', '%'.$word.'%');
                        });
                    } else {
                        $sub_query->whereRaw('MATCH(name,tagline,content) AGAINST(? IN BOOLEAN MODE)', [$word.'*']);
                    }
                }
            });
        }

        if ($request->has('tag_id')) {
            $query->whereHas('tags', function ($sub_query) use ($request){
                $sub_query->where('id', $request->input('tag_id'));
            });
        }

        $query->orderByRaw('RAND(' . Random::getUserSeed() . ')');

        $designers = $query->paginate(12);

        return view('pages.designer.index', [
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
    public function create(Request $request)
    {
        if ($request->user()->can('create-designer')) {
            return view('pages.designer.create');
        } else {
            return back()->with('warning', trans('designer.designer_number_limit'));
        }
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
        // Check permission, a user can create ONLY ONE designer page
        if ($request->user()->cannot('create-designer')) {
            abort(403);
        }

        // Validate data
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'tagline' => 'string|nullable|max:255',
            'email' => 'email|nullable|max:255',
            'city_id' => 'integer|exists:city,id',
        ]);

        // Save models
        $designer = new Designer();
        $translation = new DesignerTranslation();

        if ($request->has('email')) {
            $designer->email = $request->input('email');
        }
        if ($request->has('city_id')) {
            $designer->city_id = $request->input('city_id');
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

        ActivityLog::create([
            'action' => 'create',
            'message' => '<a href="'.$request->user()->url.'">'.htmlspecialchars($request->user()->name).
                         '</a> created designer page <a href="'.$designer->url.'">'.
                         htmlspecialchars($designer->text('name')).'</a>.',
            'level' => 100,
            'target_type' => 'designer',
            'target_id' => $designer->id,
            'user_id' => $request->user()->id,
        ]);

        // Redirect to edit page
        return redirect()->action('DesignerController@edit', [$designer]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $designer = Designer::find($id);

        if (empty($designer)) {
            abort(404);
        }

        $designer->load('translations');

        $tab = $request->input('tab', 'overview');

        if (!in_array($tab, ['overview', 'designs', 'images', 'description', 'likes'])) {
            $tab = 'overview';
        }

        $data = [
            'designer' => $designer,
            'tab' => $tab,
        ];

        switch ($tab) {
            case 'overview':
                $data['designs'] = $designer->designs()->take(6)->get();
                $data['images'] = $designer->images()->where('weight', '>', 0)->orderBy('weight', 'desc')->take(6)->get();
                $data['likes'] = $designer->likes()->with('user')->take(6)->get();
                break;
            case 'designs':
                $data['designs'] = $designer->designs()->paginate(12);
                break;
            case 'images':
                $data['images'] = $designer->images()->where('weight', '>', 0)->orderBy('weight', 'desc')->paginate(12);
                break;
            case 'likes':
                $data['likes'] = $designer->likes()->with('user')->paginate(12);
                break;
        }


        return view('pages.designer.show', $data);
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
        $designer = Designer::find($id);

        if (empty($designer)) {
            abort(404);
        }

        // Check permission
        if ($request->user()->cannot('edit-designer', $designer)) {
            abort(403);
        }

        return view('pages.designer.edit', ['designer' => $designer]);
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

        if (empty($designer)) {
            abort(404);
        }

        if ($request->user()->cannot('edit-designer', $designer)) {
            abort(403);
        }

        // Edit lock
        if ($request->input('lock')) {
            if ($designer->lock()) {
                return; // 200 OK
            } else {
                abort(423); // 423 Locked
            }
        }

        $this->validate($request, [
            'image_id' => 'integer|nullable|exists:image,id',
            'logo_id' => 'integer|nullable|exists:image,id',
            'gallery_image_ids.*' => 'integer|nullable|exists:image,id',
            'city_id' => 'integer|nullable|exists:city,id',
            'user_id' => 'integer|nullable|exists:user,id',
            'tag_ids.*' => 'integer|nullable|exists:tag,id',
            'email' => 'email|nullable|max:255',
            'phone' => 'phone|nullable|max:255',
            'website' => 'url|nullable|max:255',
            'facebook' => 'url|nullable|max:255',
            'instagram' => 'url|nullable|max:255',
            'pinterest' => 'url|nullable|max:255',
            'youtube' => 'url|nullable|max:255',
            'vimeo' => 'url|nullable|max:255',
            'translations' => 'array',
            'translations.*' => 'array',
            'translations.*.name' => 'string|nullable|max:255',
            'translations.*.tagline' => 'string|nullable|max:255',
            'translations.*.content' => 'string|nullable',
            'editor_rating' => 'integer|max:100|min:-100',
            'address' => 'array',
            'address.name' => 'string|nullable|max:255',
            'address.street' => 'string|nullable|max:255',
            'address.postcode' => 'string|nullable|max:255',
            'address.city_id' => 'integer|nullable|exists:city,id',
            'address.email' => 'email|nullable|email|max:255',
            'address.phone' => 'string|nullable|max:255',
        ]);

        // Editor rating
        if ($request->has('editor_rating')) {
            if ($request->user()->can('editor-rating')) {
                $designer->editor_rating = $request->input('editor_rating');
                $designer->save();
                return;
            } else {
                abort(403);
            }
        }

        // Transfer ownership
        if ($request->has('user_id')) {
            if ($request->user()->can('transfer-designer', $designer)) {
                $old_user = $designer->user;
                $designer->transfer($request->input('user_id'));
                $new_user = \App\User::find($request->input('user_id'));

                ActivityLog::create([
                    'action' => 'transfer',
                    'message' => '<a href="'.$request->user()->url.'">'.htmlspecialchars($request->user()->name).
                                '</a> transfered designer page <a href="'.$designer->url.'">'.
                                htmlspecialchars($designer->text('name')).'</a> from <a href="'.
                                $old_user->url.'">'.htmlspecialchars($old_user->name).
                                '</a> to <a href="'.$new_user->url.
                                '">'.htmlspecialchars($new_user->name).'</a>.',
                    'metadata' => json_encode([
                        'old_user_id' => $old_user->id,
                        'new_user_id' => $new_user->id,
                    ]),
                    'level' => 150,
                    'target_type' => 'designer',
                    'target_id' => $designer->id,
                    'user_id' => $request->user()->id,
                ]);

                return;
            } else {
                abort(403);
            }
        }

        $designer->fill($request->all());

        // Update address object
        $address_array = $request->input('address');
        $update_address = true;

        // Only update address if all fields are not empty
        foreach ($address_array as $field) {
            if (empty($field)) {
                $update_address = false;
            }
        }

        if ($update_address) {

            $address_array['user_id'] = $designer->user_id;

            if ($designer->address_id) {
                $address = $designer->address;
                $address->update($address_array);
            } else {
                $address = new Address;
                $address->fill($address_array);
                $address->save();
                $designer->address()->associate($address);
            }

        }

        $designer->save();

        if ($request->has('translations')) {
            foreach ($request->input('translations') as $locale => $texts) {
                if (!Languages::has($locale)) {
                    continue;
                }

                $translation = DesignerTranslation::firstOrCreate([
                    'designer_id' => $id,
                    'locale' => $locale,
                ]);

                $translation->update(app_array_filter($texts, ['name', 'tagline', 'content']));
            }
        }

        ActivityLog::create([
            'action' => 'edit',
            'message' => '<a href="'.$request->user()->url.'">'.htmlspecialchars($request->user()->name).
                         '</a> edited designer page <a href="'.$designer->url.'">'.
                         htmlspecialchars($designer->text('name')).'</a>.',
            'level' => 100,
            'target_type' => 'designer',
            'target_id' => $designer->id,
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

        $designer = Designer::withTrashed()->find($id);

        if (empty($designer)) {
            abort(404);
        }

        if ($request->user()->cannot('delete-designer', $designer)) {
            abort(403);
        }

        switch ($request->input('action')) {
            case 'restore':
                $designer->restoreWithRelationships();

                ActivityLog::create([
                    'action' => 'restore',
                    'message' => '<a href="'.$request->user()->url.'">'.htmlspecialchars($request->user()->name).
                                '</a> restored designer page <a href="'.$designer->url.'">'.
                                htmlspecialchars($designer->text('name')).'</a>.',
                    'level' => 150,
                    'target_type' => 'designer',
                    'target_id' => $designer->id,
                    'user_id' => $request->user()->id,
                ]);

                break;
            case 'force_delete':
                // Hard delete with related models

                ActivityLog::create([
                    'action' => 'delete',
                    'message' => '<a href="'.$request->user()->url.'">'.htmlspecialchars($request->user()->name).
                                '</a> deleted designer page <a href="'.$designer->url.'">'.
                                htmlspecialchars($designer->text('name')).'</a>.',
                    'level' => 150,
                    'target_type' => 'designer',
                    'target_id' => $designer->id,
                    'user_id' => $request->user()->id,
                ]);

                $designer->forceDeleteWithRelationships();

                break;
            default:
                // Soft delete with related models
                $designer->deleteWithRelationships();

                ActivityLog::create([
                    'action' => 'trash',
                    'message' => '<a href="'.$request->user()->url.'">'.htmlspecialchars($request->user()->name).
                                '</a> trashed designer page <a href="'.$designer->url.'">'.
                                htmlspecialchars($designer->text('name')).'</a>.',
                    'level' => 150,
                    'target_type' => 'designer',
                    'target_id' => $designer->id,
                    'user_id' => $request->user()->id,
                ]);
        }
    }
}
