<?php

namespace App\Http\Controllers;

use App\Design;
use App\Designer;
use App\Support\Random;

use Auth;

use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * Home page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->validate($request, [
            'tag_id' => 'integer|exists:tag,id',
        ]);
        // Designs
        $query = Design::with('image', 'translations', 'designer.logo', 'designer.translations')
            ->whereNotNull('image_id')->where('editor_rating', '>', -1);

        if ($request->has('tag_id')) {
            $query->whereHas('tags', function ($sub_query) use ($request){
                $sub_query->where('id', $request->input('tag_id'));
            });
        }

        $designs = $query->orderByRaw('editor_rating * 0.01 + RAND(' . Random::getUserSeed() . ') desc')
            ->paginate(24);

        // Featured designers
        $designers = Designer::with('logo', 'image', 'translations')
            ->whereNotNull('logo_id')
            ->whereNotNull('image_id')
            ->where('editor_rating', '>', 80)
            ->orderByRaw('RAND()')
            ->take(4)->get();

        return view('pages.home', [
            'designs' => $designs,
            'designers' => $designers,
        ]);
    }

}
