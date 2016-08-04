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

    <section id="story-list" class="article-list">
        <h2 class="heading">
            <div class="inner">{{ trans('story.stories') }}</div>
        </h2>
        <div class="list">
            @foreach ($stories as $story)
                <article>
                    <a href="{{ $story->url }}">
                        <div class="cover">
                            @if ($story->image_id)
                                <img class="image" src="{{ $story->image->thumb_file_url }}"
                                    srcset="{{ $story->image->largethumb_file_url }} 2x"/>
                            @endif
                        </div>
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

    <section id="designer-list" class="article-list">
        <h2 class="heading">
            <div class="inner">{{ trans('designer.designers') }}</div>
        </h2>
        <div class="list">
            @foreach ($designers as $designer)
                <article>
                    <a href="{{ $designer->url }}">
                        <div class="cover">
                            @if ($designer->image_id)
                                <img class="image" src="{{ $designer->image->thumb_file_url }}"
                                    srcset="{{ $designer->image->largethumb_file_url }} 2x"/>
                            @endif
                            @if ($designer->logo_id)
                                <img class="logo" src="{{ $designer->logo->small_file_url }}"/>
                            @endif
                        </div>
                        <div class="text">
                            <div class="inner">
                                <h2>{{ $designer->text('name') }}<br></h2>
                                <div class="tagline text-muted">{{ $designer->text('tagline') }}</div>
                                <div class="excerpt">{{ $designer->excerpt('content') }}</div>
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

    <section id="place-list" class="article-list">
        <h2 class="heading">
            <div class="inner">{{ trans('place.places') }}</div>
        </h2>
        <div class="list">
            @foreach ($places as $place)
                <article>
                    <a href="{{ $place->url }}">
                        <div class="cover">
                            @if ($place->image_id)
                                <img class="image" src="{{ $place->image->thumb_file_url }}"
                                    srcset="{{ $place->image->largethumb_file_url }} 2x"/>
                            @endif
                        </div>
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

    <section id="tag-list" class="article-list">
        <h2 class="heading">
            <div class="inner">{{ trans('common.tags') }}</div>
        </h2>
        <div class="list">
            @foreach ($tags as $tag)
                <article>
                    <a href="{{ $tag->url }}">
                        @if ($tag->image_id)
                            <div class="cover" style="background-image:url({{ $tag->image->fileUrl('thumb') }})">
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
