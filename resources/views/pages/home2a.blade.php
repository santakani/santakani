@extends('layouts.app', [
    'body_id' => 'home-page',
    'body_classes' => ['home-page', 'index-page'],
    'active_nav' => 'home',
    'nav_no_design' => true,
])

@section('header')
    <div id="slides" class="slides">
        <div class="slide" style="background-image:url(/img/banner/1.jpg)">
            <div class="text">
                <h1>{{ trans('home.slide_1.title') }}</h1>
                <p>{{ trans('home.slide_1.content') }}</p>
                <a class="btn btn-default" href="/designer" role="button">{{ trans('designer.designer_list') }}</a>
                <a class="btn btn-default" href="/designer/create" role="button">{{ trans('designer.create_a_designer_page') }}</a>
            </div><!-- .text -->
        </div><!-- .slide -->
        <div class="slide" style="background-image:url(/img/banner/2.jpg)">
            <div class="text">
                <h1>{{ trans('home.slide_2.title') }}</h1>
                <p>{{ trans('home.slide_2.content') }}</p>
                <a class="btn btn-default" href="/place" role="button">{{ trans('geo.map') }}</a>
                <a class="btn btn-default" href="/place/create" role="button">{{ trans('place.create_a_place_page') }}</a>
            </div>
        </div><!-- .slide -->
        <div class="slide" style="background-image:url(/img/banner/3.jpg)">
            <div class="text">
                <h1>{{ trans('home.slide_3.title') }}</h1>
                <p>{{ trans('home.slide_3.content') }}</p>
                <a class="btn btn-default" href="/story" role="button">{{ trans('story.story_list') }}</a>
                <a class="btn btn-default" href="/story/create" role="button">{{ trans('story.write_a_design_story') }}</a>
            </div>
        </div><!-- .slide -->
    </div>
@endsection

@section('main')

    <div id="design-list" class="article-list">
        <div class="list">
            @foreach ($designs as $design)
                <article>
                    <a href="{{ $design->url }}">
                        <div class="cover">
                            @if ($design->image_id)
                                <img class="image" src="{{ $design->image->thumb_file_url }}"
                                    srcset="{{ $design->image->largethumb_file_url }} 2x"/>
                            @else
                                <img class="image" src="{{ url('img/placeholder/square.png') }}"/>
                            @endif
                            @if ($design->logo_id)
                                <img class="logo" src="{{ $design->logo->small_file_url }}"/>
                            @endif
                        </div>
                        <div class="text">
                            <div class="inner">
                                <h2>{{ $design->text('name') }}<br></h2>
                                <div class="excerpt">{{ $design->excerpt('content') }}</div>
                            </div>
                        </div>
                    </a>
                </article>
            @endforeach
        </div>

        <br><br>

        <div class="text-center">
            <i class="fa fa-circle-o-notch fa-spin fa-2x"></i> <br> Loading...
        </div>

        <br><br>

    </div><!-- #design-list -->

@endsection
