<?php

if ($designer->image_id) {
    $cover_image = $designer->image->getFileUrl('large');
} else {
    $cover_image = url('img/placeholder/blank/1200x800.svg');
}

if ($designer->logo_id) {
    $logo_image = $designer->logo->getFileUrl('thumb');
} else {
    $logo_image = url('img/placeholder/blank/300x300.svg');
}

?>

@extends('layouts.app', [
    'title' => $designer->text('name') . ' - Designer',
    'body_id' => 'designer-show-page',
    'body_classes' => ['designer-show-page', 'show-page', 'designer-page'],
    'active_nav' => 'designer',
])

@section('header')

<div class="page-cover container" style="background-image:url({{ $cover_image }});">

    <div class="raster raster-dark-dot"></div>

    <div class="action-buttons float">
        @include('components.buttons.like', ['likeable' => $designer])
        @if (Auth::user()->can('edit-designer', $designer))
            @include('components.buttons.edit')
        @endif
        @if (Auth::user()->can('delete-designer', $designer))
            @include('components.buttons.delete')
        @endif
    </div><!-- /.action-buttons -->

    <div class="text">

        <img class="logo-image" src="{{ $logo_image }}"/>

        <h1 class="name">{{ $designer->text('name') }}</h1>

        <p class="tagline">{{ $designer->text('tagline') }}</p>

    </div><!-- /.text-->

</div><!-- /.container -->
@endsection

@section('main')
    @if ($designer->city && $designer->country)
        <p class="location">
            <a href="{{ $designer->city->url }}">
                {{ $designer->city->text('name') }}
            </a>,
            <a href="{{ $designer->country->url }}">
                {{ $designer->country->text('name') }}
            </a>
        </p>
    @endif

    <p class="links">
        @if (!empty($designer->facebook))
            <a href="{{ $designer->facebook }}">
                <i class="fa fa-facebook"></i>
            </a>
        @endif
        @if (!empty($designer->twitter))
            <a href="{{ $designer->twitter }}">
                <i class="fa fa-twitter"></i>
            </a>
        @endif
        @if (!empty($designer->google_plus))
            <a href="{{ $designer->google_plus }}">
                <i class="fa fa-google-plus"></i>
            </a>
        @endif
        @if (!empty($designer->instagram))
            <a href="{{ $designer->instagram }}">
                <i class="fa fa-instagram"></i>
            </a>
        @endif
        @if (!empty($designer->email))
            <a href="mailto:{{ $designer->email }}">
                <i class="fa fa-envelope"></i>
            </a>
        @endif
        @if (!empty($designer->email))
            <a href="{{ $designer->website }}">
                <i class="fa fa-globe"></i>
            </a>
        @endif
    </p>

<div class="content container-600">

    {!! $designer->text('content') !!}

    @include('components.tag-list', [
        'tags' => $designer->tags,
        'style' => 'plain',
    ])
</div>

<div class="container-fluid">
    <div class="gallery">
        @foreach ($designer->gallery_images as $image)
            <a href="{{ $image->file_urls['large'] }}">
                <img src="{{ $image->file_urls['thumb'] }}" />
            </a>
        @endforeach
    </div>
</div>
@endsection
