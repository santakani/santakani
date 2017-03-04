<?php

namespace App\Http\Controllers;

use App\Design;
use App\Option;
use App\OptionTranslation;

use Illuminate\Http\Request;

class OptionController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Only logged in users can upload images
        $this->middleware('auth', ['except' => ['index','show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Validate data
        $this->validate($request, [
            'design_id' => 'required|integer|exists:design,id',
            'type' => 'required|string|in:color,size,material,custom',
        ]);

        $options = Option::where([
            ['design_id', $request->input('design_id')],
            ['type', $request->input('type')],
        ]);

        return response()->json($options);
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
            'design_id' => 'required|integer|exists:design,id',
            'type' => 'required|string|in:color,size,material,custom',
            'image_id' => 'integer|nullable|exists:image,id',
            'price_add' => 'numeric|nullable|between:-999999.99,999999.99',
            'value' => 'string|nullable|max:255',
            'available' => 'boolean',
            'translations' => 'array',
            'translations.*.name' => 'string|nullable|max:255',
        ]);

        if ($request->user()->cannot('edit-design', Design::find($request->input('design_id')))) {
            abort(403);
        }

        $option = new Option();

        $option->design_id = $request->input('design_id');
        $option->type = $request->input('type');
        $option->image_id = $request->input('image_id');
        $option->price_add = $request->input('price_add');
        $option->value = $request->input('value');
        $option->available = $request->input('available');

        $option->save();

        if ($request->has('translations')) {
            foreach ($request->input('translations') as $t) {
                if ( !in_array($t['locale'], config('app.available_locale')) ) {
                    continue;
                }

                $translation = OptionTranslation::firstOrNew([
                    'option_id' => $option->id,
                    'locale' => $t['locale'],
                ]);

                $translation->name = $t['name'];
                $translation->save();
            }
        }

        return response()->json($option);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $option = Option::find($id);

        if (empty($option)) {
            abort(404);
        }

        return response()->json($option);
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
        $option = Option::find($id);

        if (empty($option)) {
            abort(404);
        }

        if ($request->user()->cannot('edit-design', $option->design)) {
            abort(403);
        }

        $this->validate($request, [
            'image_id' => 'integer|nullable|exists:image,id',
            'price_add' => 'numeric|nullable|between:-999999.99,999999.99',
            'value' => 'string|nullable|max:255',
            'available' => 'boolean',
            'translations' => 'array',
            'translations.*.name' => 'string|nullable|max:255',
        ]);

        $option->image_id = $request->input('image_id');
        $option->price_add = $request->input('price_add');
        $option->value = $request->input('value');
        $option->available = $request->input('available');

        $option->save();

        if ($request->has('translations')) {
            foreach ($request->input('translations') as $t) {
                if ( !in_array($t['locale'], config('app.available_locale')) ) {
                    continue;
                }

                $translation = OptionTranslation::firstOrNew([
                    'option_id' => $option->id,
                    'locale' => $t['locale'],
                ]);

                $translation->name = $t['name'];
                $translation->save();
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
        $option = Option::find($id);

        if (empty($option)) {
            abort(404);
        }

        if ($request->user()->cannot('edit-design', $option->design)) {
            abort(403);
        }

        $option->delete();
    }
}
