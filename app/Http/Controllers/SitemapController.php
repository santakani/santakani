<?php

namespace App\Http\Controllers;


use Carbon\Carbon;

use App;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Designer;
use App\Place;
use App\Story;
use App\Tag;

class SitemapController extends Controller
{
    public function index() {
        // create new sitemap object
        $sitemap = App::make("sitemap");

        // set cache key (string), duration in minutes (Carbon|Datetime|int), turn on/off (boolean)
        // by default cache is disabled
        $sitemap->setCache('laravel.sitemap', 60);

        // check if there is cached sitemap and build new only if is not
        if (!$sitemap->isCached()) {
             // add item to the sitemap (url, date, priority, freq)
             $sitemap->add(url('about'), Carbon::createFromDate(2016, 7, 15), '0.3', 'monthly');
             $sitemap->add(url('privacy'), Carbon::createFromDate(2016, 7, 15), '0.3', 'monthly');
             $sitemap->add(url('terms'), Carbon::createFromDate(2016, 7, 15), '0.3', 'monthly');

             $designers = Designer::orderBy('created_at', 'desc')->get();
             foreach ($designers as $designer) {
                $sitemap->add($designer->url, $designer->updated_at, 0.8, 'daily');
             }

             $places = Place::orderBy('created_at', 'desc')->get();
             foreach ($places as $place) {
                $sitemap->add($place->url, $place->updated_at, 0.8, 'daily');
             }

             $stories = Story::orderBy('created_at', 'desc')->get();
             foreach ($stories as $story) {
                $sitemap->add($story->url, $story->updated_at, 0.8, 'daily');
             }

             $tags = Tag::orderBy('created_at', 'desc')->get();
             foreach ($tags as $tag) {
                $sitemap->add($tag->url, $tag->updated_at, 0.8, 'weekly');
             }
        }

        // show your sitemap (options: 'xml' (default), 'html', 'txt', 'ror-rss', 'ror-rdf')
        return $sitemap->render('xml');

    }
}
