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
        $designers = Designer::has('images')
            ->whereNotNull('logo_id')
            ->orderBy('editor_pick', 'desc')
            ->orderByRaw('RAND(' . Random::getUserSeed() . ')')
            ->paginate(30);

        return view('pages.home', [
            'designers' => $designers,
        ]);
    }

}
