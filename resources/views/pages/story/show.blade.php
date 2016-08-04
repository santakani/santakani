@extends('layouts.app', [
    'title' => $story->text('title') . ' - ' . trans('story.story'),
    'body_id' => 'story-show-page',
    'body_classes' => ['story-show-page', 'story-page', 'show-page'],
    'active_nav' => 'story',
    'og_title' => $story->text('title'),
    'og_url' => $story->url,
    'og_description' => $story->excerpt('content'),
    'og_image' => empty($story->image_id)?'':$story->image->fileUrl('medium'),
])

@section('header')
    <div class="container">

        @if ($story->image_id)
            <div class="cover-image" style="background-image:url({{ $story->image->fileUrl('large') }})"></div>
        @else
            <div class="cover-image" style="background-image:url(/img/placeholder/blank/1200x800.svg)"></div>
        @endif

        <div class="raster raster-dark-dot"></div>

        <div class="action-buttons">
            @include('components.buttons.like', ['likeable' => $story])
            @if (Auth::check())
                @if (Auth::user()->can('edit-story', $story))
                    @include('components.buttons.edit')
                @endif
                @if (Auth::user()->can('delete-story', $story))
                    @include('components.buttons.delete')
                @endif
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
                {!! $story->html('content') !!}
            </div>

            @include('components.tag-list', [
                'tags' => $story->tags,
                'style' => 'round',
            ])

        </div><!-- .col -->
    </div><!-- .row -->
</div><!-- .container -->
@endsection
