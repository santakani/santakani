@extends('layout.app', [
    'title' => $story->text('title') . ' - ' . trans('story.story'),
    'body_id' => 'story-show-page',
    'body_classes' => ['story-show-page', 'story-page', 'show-page'],
    'active_nav' => 'story',
])

@section('header')
    <div class="container">

        @if ($story->image_id)
            <div class="cover-image" style="background-image:url({{ $story->image->getFileUrl('large') }})"></div>
        @else
            <div class="cover-image" style="background-image:url(/img/placeholder/blank/1200x800.svg)"></div>
        @endif

        <div class="raster raster-dark-dot"></div>

        <div class="action-buttons">
            <button type="button" id="like-button" class="btn btn-default"
                data-likeable-id="{{ $story->id}}" data-likeable-type="story"
                data-liked="{{ $story->liked }}">
                <i class="fa fa-lg {{ $story->liked?'fa-heart':'fa-heart-o' }}"></i>
                Like
                <span class="badge">{{ $story->like_count }}</span>
            </button>
            @if ($can_edit)
                <a id="edit-button" class="btn btn-default" href="{{ $story->url . '/edit' }}">
                    <i class="fa fa-pencil-square-o fa-lg"></i> Edit</a>
                <button type="button" id="delete-button" class="btn btn-danger">
                    <i class="fa fa-trash-o fa-lg"></i> Delete</a>
            @endif
        </div>

        <h1 class="title">{{ $story->text('title') }}</h1>

        <div class="meta">
            <p class="author">{{ $story->user->name }}</p>
            <p>{{ $story->created_at }}</p>
        </div>

    </div><!-- .container -->
@endsection

@section('main')
<div class="container">
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">

            <div class="content">
                {!! $story->text('content') !!}
            </div>

            @include('component.tag-list', [
                'tags' => $story->tags,
                'style' => 'round',
            ])

        </div><!-- .col -->
    </div><!-- .row -->
</div><!-- .container -->
@endsection
