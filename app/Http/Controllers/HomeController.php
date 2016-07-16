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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $designers = Designer::whereNotNull('image_id')->orderBy('id', 'desc')->take(6)->get();
        $places = Place::whereNotNull('image_id')->orderBy('id', 'desc')->take(6)->get();
        $stories = Story::whereHas('translations', function ($sub_query) {
            $sub_query->whereIn('locale', ['en', App::getLocale()])->whereNotNull('title')
                ->whereNotNull('content');
        })->whereNotNull('image_id')->orderBy('id', 'desc')->take(6)->get();
        $tags = Tag::whereNotNull('image_id')->orderBy('level', 'desc')->take(12)->get();

        return view('pages.index', [
            'designers' => $designers,
            'places' => $places,
            'stories' => $stories,
            'tags' => $tags,
        ]);
    }
}
