<?php

/*
 * This file is part of santakani.com
 *
 * (c) Guo Yunhe <guoyunhebrave@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\City;
use App\Country;
use App\Design;
use App\Designer;
use App\Place;
use App\Story;
use App\Tag;
use App\User;

/**
 * Static pages controller.
 *
 * @author Guo Yunhe <guoyunhebrave@gmail.com>
 */
class PageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Privacy page
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function privacy(Request $request)
    {
        return view('pages.privacy');
    }

    /**
     * About us page
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function about(Request $request)
    {
        $data['designer_number'] = Designer::count();
        $data['design_number'] = Design::count();
        $data['place_number'] = Place::count();
        $data['story_number'] = Story::count();
        $data['tag_number'] = Tag::count();
        $data['user_number'] = User::count();
        $data['city_number'] = City::has('places')->orHas('designers')->count();

        return view('pages.about', $data);
    }

    /**
     * Terms of service page
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function terms(Request $request)
    {
        return view('pages.terms');
    }
}
