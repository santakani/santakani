@extends('layouts.app', [
    'body_id' => 'home-page',
    'body_classes' => ['home-page', 'index-page'],
    'active_nav' => 'home',
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

    <section id="story-list">
        <h2 class="heading">
            <div class="inner">{{ trans('story.stories') }}</div>
        </h2>
        <div class="list">
            @foreach ($stories as $story)
                <article>
                    <a href="{{ $story->url }}">
                        @if ($story->image_id)
                            <div class="cover" style="background-image:url({{ $story->image->url('thumb') }})"></div>
                        @else
                            <div class="cover" style="background-image:url('/img/placeholder/blank/300x300.svg')"></div>
                        @endif
                        <div class="text">
                            <div class="inner">
                                <h3>{{ $story->title }}</h3>
                                <p class="excerpt">{{ $story->excerpt('content') }}</p>
                            </div>
                        </div>
                    </a>
                </article>
            @endforeach
            <article class="more-button">
                <a href="{{ url('story') }}">
                    <i class="fa fa-2x fa-plus-square-o"></i>
                    <br>
                    {{ trans('common.more') }}
                </a>
            </article>
        </div>
    </section>

    <section id="designer-list">
        <h2 class="heading">
            <div class="inner">{{ trans('designer.designers') }}</div>
        </h2>
        <div class="list">
            @foreach ($designers as $designer)
                <article>
                    <a href="{{ $designer->url }}">
                        @if ($designer->image_id)
                            <div class="cover" style="background-image:url({{ $designer->image->url('thumb') }})"></div>
                        @else
                            <div class="cover" style="background-image:url('/img/placeholder/blank/300x300.svg')"></div>
                        @endif
                        <div class="text">
                            <div class="inner">
                                <h3>{{ $designer->name }}</h3>
                                <p class="excerpt">{{ $designer->excerpt('content') }}</p>
                            </div>
                        </div>
                    </a>
                </article>
            @endforeach
            <article class="more-button">
                <a href="{{ url('designer') }}">
                    <i class="fa fa-2x fa-plus-square-o"></i>
                    <br>
                    {{ trans('common.more') }}
                </a>
            </article>
        </div>
    </section>

    <section id="place-list">
        <h2 class="heading">
            <div class="inner">{{ trans('place.places') }}</div>
        </h2>
        <div class="list">
            @foreach ($places as $place)
                <article>
                    <a href="{{ $place->url }}">
                        @if ($place->image_id)
                            <div class="cover" style="background-image:url({{ $place->image->url('thumb') }})"></div>
                        @else
                            <div class="cover" style="background-image:url('/img/placeholder/blank/300x300.svg')"></div>
                        @endif
                        <div class="text">
                            <div class="inner">
                                <h3>{{ $place->name }} <small>{{ $place->city->full_name }}</small></h3>

                                <p class="excerpt">{{ $place->excerpt('content') }}</p>
                            </div>
                        </div>
                    </a>
                </article>
            @endforeach
            <article class="more-button">
                <a href="{{ url('place') }}">
                    <i class="fa fa-2x fa-plus-square-o"></i>
                    <br>
                    {{ trans('common.more') }}
                </a>
            </article>
        </div>
    </section>

    <section id="tag-list">
        <h2 class="heading">
            <div class="inner">{{ trans('common.tags') }}</div>
        </h2>
        <div class="list">
            @foreach ($tags as $tag)
                <article>
                    <a href="{{ $tag->url }}">
                        @if ($tag->image_id)
                            <div class="cover" style="background-image:url({{ $tag->image->url('thumb') }})">
                                <div class="text"><h3>{{ $tag->name }}</h3></div>
                            </div>
                        @else
                            <div class="cover" style="background-image:url('/img/placeholder/blank/300x300.svg')">
                                <div class="text"><h3>{{ $tag->name }}</h3></div>
                            </div>
                        @endif
                    </a>
                </article>
            @endforeach
            <article class="more-button">
                <a href="{{ url('tag') }}">
                    <i class="fa fa-2x fa-plus-square-o"></i>
                    <br>
                    {{ trans('common.more') }}
                </a>
            </article>
        </div>
    </section>
@endsection
