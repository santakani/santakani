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
        $designers = Designer::orderByRaw('RAND(' . Random::getUserSeed() . ')')->get();
        return view('pages.home', [
            'designers' => $designers,
        ]);
    }

}
