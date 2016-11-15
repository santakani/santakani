<?php

namespace App\Http\Controllers;

use App;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Designer;
use App\Place;
use App\Story;
use App\Support\Random;
use App\Tag;

class HomeController extends Controller
{
    /**
     * Show the home page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $designers = Designer::orderByRaw('RAND(' . Random::getUserSeed() . ')')->take(9)->get();
        $places = Place::orderByRaw('RAND(' . Random::getUserSeed() . ')')->take(9)->get();
        $stories = Story::whereHas('translations', function ($sub_query) {
            $sub_query->whereIn('locale', ['en', App::getLocale()])->whereNotNull('title')
                ->whereNotNull('content');
        })->orderBy('created_at', 'desc')->take(9)->get();
        $tags = Tag::orderByRaw('RAND(' . Random::getUserSeed() . ')')->take(9)->get();

        return view('pages.home', [
            'designers' => $designers,
            'places' => $places,
            'stories' => $stories,
            'tags' => $tags,
        ]);
    }
}
