<?php

namespace App\Http\Controllers;

use App\Http\Requests;
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
        $designers = Designer::with('logo', 'image', 'translations', 'designs', 'designs.image', 'designs.translations')
            ->whereNotNull('logo_id')
            ->whereNotNull('image_id')
            ->orderBy('editor_pick', 'desc')
            ->orderByRaw('RAND(' . Random::getUserSeed() . ')')
            ->paginate(24);

        return view('pages.home', [
            'designers' => $designers,
        ]);
    }

}
