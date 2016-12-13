@extends('layouts.app', [
    'body_id' => 'home-page',
    'body_classes' => ['home-page', 'index-page'],
    'active_nav' => 'home',
])

@section('header')
    <div class="video-header page-cover">
        <video class="video-background" src="/video/home-page-header.mp4" width="1280" height="720" autoplay="autoplay" loop="loop"></video>
        <h1 class="title">Find Independent Design</h1>
        <p>
            <a class="btn btn-lg btn-info" href="/designer/create" role="button">{{ strtoupper(trans('designer.create_a_designer_page')) }}</a>
            <a class="btn btn-lg btn-success" href="/place/create" role="button">{{ strtoupper(trans('place.create_a_place_page')) }}</a>
        </p>

        <p><br></p>

        <input type="search" class="form-control input-lg" placeholder="Search"/>

        <div class="browse-down"><i class="fa fa-angle-double-down"></i></div>
    </div>
@endsection

@section('main')

    <section id="design-list" class="article-list">
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

    </section><!-- #design-list -->

@endsection
