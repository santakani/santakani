<?php

namespace App\Http\Controllers;

use App;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Designer;
use App\Place;
use App\Story;
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
        $designers = Designer::orderBy('id', 'desc')->take(12)->get();
        $places = Place::orderBy('id', 'desc')->take(12)->get();
        $stories = Story::whereHas('translations', function ($sub_query) {
            $sub_query->whereIn('locale', ['en', App::getLocale()])->whereNotNull('title')
                ->whereNotNull('content');
        })->orderBy('id', 'desc')->take(12)->get();
        $tags = Tag::orderByRaw('RAND()')->take(12)->get();

        return view('pages.index', [
            'designers' => $designers,
            'places' => $places,
            'stories' => $stories,
            'tags' => $tags,
        ]);
    }
}
