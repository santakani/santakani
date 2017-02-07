<?php

namespace App\Http\Controllers;

use App;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Design;
use App\Designer;
use App\Place;
use App\Story;
use App\Support\Random;
use App\Tag;

class HomeController extends Controller
{

    /**
     * Home page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $designers = Designer::orderBy('editor_pick', 'desc')->orderByRaw('RAND(' . Random::getUserSeed() . ')')->paginate(30);
        return view('pages.home', [
            'designers' => $designers,
        ]);
    }

}
