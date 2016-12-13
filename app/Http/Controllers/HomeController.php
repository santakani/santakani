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

    /**
     * Testing home page 1A. https://santakani.com/home1a
     *
     * Group 1 : header test
     * Design A: video header, a time lapse video showing designers' life
     *
     * @return \Illuminate\Http\Response
     */
    public function index1a()
    {
        $designers = Designer::orderByRaw('RAND(' . Random::getUserSeed() . ')')->take(9)->get();
        $places = Place::orderByRaw('RAND(' . Random::getUserSeed() . ')')->take(9)->get();
        $stories = Story::whereHas('translations', function ($sub_query) {
            $sub_query->whereIn('locale', ['en', App::getLocale()])->whereNotNull('title')
                ->whereNotNull('content');
        })->orderBy('created_at', 'desc')->take(9)->get();
        $tags = Tag::orderByRaw('RAND(' . Random::getUserSeed() . ')')->take(9)->get();
        return view('pages.home1a', [
            'designers' => $designers,
            'places' => $places,
            'stories' => $stories,
            'tags' => $tags,
        ]);
    }

    /**
     * Testing home page 1B. https://santakani.com/home1b
     *
     * Group 1 : header test
     * Design B: clean and static photo header, no slides
     *
     * @return \Illuminate\Http\Response
     */
    public function index1b()
    {
        $designers = Designer::orderByRaw('RAND(' . Random::getUserSeed() . ')')->take(9)->get();
        $places = Place::orderByRaw('RAND(' . Random::getUserSeed() . ')')->take(9)->get();
        $stories = Story::whereHas('translations', function ($sub_query) {
            $sub_query->whereIn('locale', ['en', App::getLocale()])->whereNotNull('title')
                ->whereNotNull('content');
        })->orderBy('created_at', 'desc')->take(9)->get();
        $tags = Tag::orderByRaw('RAND(' . Random::getUserSeed() . ')')->take(9)->get();
        return view('pages.home1b', [
            'designers' => $designers,
            'places' => $places,
            'stories' => $stories,
            'tags' => $tags,
        ]);
    }

    /**
     * Testing home page 1C. https://santakani.com/home1c
     *
     * Group 1 : header test
     * Design C: pure text header
     *
     * @return \Illuminate\Http\Response
     */
    public function index1c()
    {
        $designers = Designer::orderByRaw('RAND(' . Random::getUserSeed() . ')')->take(9)->get();
        $places = Place::orderByRaw('RAND(' . Random::getUserSeed() . ')')->take(9)->get();
        $stories = Story::whereHas('translations', function ($sub_query) {
            $sub_query->whereIn('locale', ['en', App::getLocale()])->whereNotNull('title')
                ->whereNotNull('content');
        })->orderBy('created_at', 'desc')->take(9)->get();
        $tags = Tag::orderByRaw('RAND(' . Random::getUserSeed() . ')')->take(9)->get();
        return view('pages.home1c', [
            'designers' => $designers,
            'places' => $places,
            'stories' => $stories,
            'tags' => $tags,
        ]);
    }

    /**
     * Testing home page 2A. https://santakani.com/home2a
     *
     * Group 2 : list test
     * Design A: only designs
     *
     * @return \Illuminate\Http\Response
     */
    public function index2a()
    {
        $query = Design::query();

        $query->whereNotNull('image_id');

        $query->orderByRaw('RAND(' . Random::getUserSeed() . ')');

        $designs = $query->paginate(24);

        return view('pages.home2a', [
            'designs' => $designs
        ]);
    }

    /**
     * Testing home page 2B. https://santakani.com/home2b
     *
     * Group 2 : list test
     * Design B: mixed list of designs, designers and stories
     *
     * @return \Illuminate\Http\Response
     */
    public function index2b()
    {
        $query = Design::query();

        $query->whereNotNull('image_id');

        $query->orderByRaw('RAND(' . Random::getUserSeed() . ')');

        $designs = $query->paginate(24);

        $designers = Designer::orderByRaw('RAND(' . Random::getUserSeed() . ')')->take(9)->get();
        $places = Place::orderByRaw('RAND(' . Random::getUserSeed() . ')')->take(9)->get();
        $stories = Story::whereHas('translations', function ($sub_query) {
            $sub_query->whereIn('locale', ['en', App::getLocale()])->whereNotNull('title')
                ->whereNotNull('content');
        })->orderBy('created_at', 'desc')->take(9)->get();
        $tags = Tag::orderByRaw('RAND(' . Random::getUserSeed() . ')')->take(9)->get();

        return view('pages.home2b', [
            'designs' => $designs,
            'designers' => $designers,
            'places' => $places,
            'stories' => $stories,
            'tags' => $tags,
        ]);
    }
}
