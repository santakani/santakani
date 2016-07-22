<?php

if ($designer->image_id) {
    $cover_image = $designer->image->url('large');
} else {
    $cover_image = url('img/placeholder/blank/1200x800.svg');
}

if ($designer->logo_id) {
    $logo_image = $designer->logo->url('thumb');
} else {
    $logo_image = url('img/placeholder/blank/300x300.svg');
}

?>

@extends('layouts.app', [
    'title' => $designer->text('name') . ' - ' . trans('designer.designers'),
    'body_id' => 'designer-show-page',
    'body_classes' => ['designer-show-page', 'show-page', 'designer-page'],
    'active_nav' => 'designer',
])

@section('header')
    <div class="page-cover" style="background-image:url({{ $cover_image }});">

        <div class="raster raster-dark-dot"></div>

        <div class="action-buttons float">
            @include('components.buttons.like', ['likeable' => $designer])
            @if (Auth::check())
                @if (Auth::user()->can('edit-designer', $designer))
                    @include('components.buttons.edit')
                @endif
                @if (Auth::user()->can('delete-designer', $designer))
                    @include('components.buttons.delete')
                @endif
            @endif
        </div><!-- /.action-buttons -->

        <div class="text">
            <img class="logo-image" src="{{ $logo_image }}"/>
            <h1 class="name">{{ $designer->text('name') }}</h1>
            <p class="tagline">{{ $designer->text('tagline') }}</p>
        </div><!-- /.text-->

    </div><!-- /.page-cover.container -->
@endsection

@section('main')
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-lg-3 hidden-sm hidden-xs">

                <h4>{{ trans('common.tags') }}</h4>
                @include('components.tag-list', [
                    'tags' => $designer->tags,
                    'style' => 'round',
                ])

                <h4>{{ trans('geo.location') }}</h4>
                @if ($designer->city_id)
                    <p>{{ $designer->city->full_name }}</p>
                @else
                    <p>{{ trans('common.unknown') }}</p>
                @endif

                <h4>{{ trans('common.links') }}</h4>
                <div class="links">
                    @if (!empty($designer->facebook))
                        <a href="{{ $designer->facebook }}" title="Facebook">
                            <i class="fa fa-facebook-official"></i>
                        </a>
                    @endif
                    @if (!empty($designer->twitter))
                        <a href="{{ $designer->twitter }}" title="Twitter">
                            <i class="fa fa-twitter"></i>
                        </a>
                    @endif
                    @if (!empty($designer->google_plus))
                        <a href="{{ $designer->google_plus }}" title="Google+">
                            <i class="fa fa-google-plus"></i>
                        </a>
                    @endif
                    @if (!empty($designer->instagram))
                        <a href="{{ $designer->instagram }}" title="Instagram">
                            <i class="fa fa-instagram"></i>
                        </a>
                    @endif
                    @if (!empty($designer->email))
                        <a href="mailto:{{ $designer->email }}" title="{{ trans('common.email') }}">
                            <i class="fa fa-envelope"></i>
                        </a>
                    @endif
                    @if (!empty($designer->email))
                        <a href="{{ $designer->website }}" title="{{ trans('common.website') }}">
                            <i class="fa fa-globe"></i>
                        </a>
                    @endif
                </div>
            </div><!-- /.col-* -->

            <div class="col-md-8 col-lg-9">
                <!-- Nav tabs -->
                <ul id="main-tabs" class="nav nav-strokes nav-justified nav-lg" role="tablist">
                    <li role="presentation" class="active"><a href="#gallery" aria-controls="home" role="tab" data-toggle="tab">{{ trans('common.gallery') }}</a></li>
                    <li role="presentation"><a href="#biography" aria-controls="biography" role="tab" data-toggle="tab">{{ trans('common.about') }}</a></li>
                    <li role="presentation"><a href="#followers" aria-controls="followers" role="tab" data-toggle="tab">{{ trans('common.followers') }}</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="gallery">
                        <div class="row">
                            @foreach ($designer->gallery_images as $image)
                                <div class="col-xs-4">
                                    <a href="{{ $image->url('large') }}">
                                        <img src="{{ $image->url('thumb') }}" />
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="biography">
                        {!! $designer->html('content') !!}
                    </div>
                    <div role="tabpanel" class="tab-pane" id="followers">
                        <div class="row">
                            @foreach ($designer->likes as $like)
                                <div class="col-sm-6 col-lg-4">
                                    <article class="user material-card">
                                        <img class="avatar" src="{{ $like->user->avatar(150) }}"/>
                                        <div class="text">
                                            <div class="name">{{ $like->user->name }}</div>
                                            <div class="description text-muted">{{ $like->user->description }}</div>
                                        </div>
                                    </article>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div><!-- /.col-* -->
        </div><!-- /.row -->
    </div><!-- /.container -->
@endsection
