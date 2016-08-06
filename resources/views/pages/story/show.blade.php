@extends('layouts.app', [
    'title' => $story->text('title') . ' - ' . trans('story.story'),
    'body_id' => 'story-show-page',
    'body_classes' => ['story-show-page', 'story-page', 'show-page'],
    'active_nav' => 'story',
    'og_title' => $story->text('title'),
    'og_url' => $story->url,
    'og_description' => $story->excerpt('content'),
    'og_image' => empty($story->image_id)?'':$story->image->fileUrl('medium'),
    'has_share_buttons' => true,
])

@section('header')
    <div class="page-cover"
        @if ($story->image_id)
            style="background-image:url({{ $story->image->large_file_url }})"
        @endif
        >

        <div class="raster raster-dark-dot"></div>

        <div class="buttons">
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

        <p class="author">
            <a href="{{ $story->user->url }}">
                <img class="avatar" src="{{ $story->user->small_avatar_url }}"
                    srcset="{{ $story->user->medium_avatar_url }} 3x, {{ $story->user->large_avatar_url }} 6x"
                    width="50" height="50">
                <span class="user-name">{{ $story->user->name }}</span>
            </a>
        </p>

        <p class="date">{{ $story->created_at->formatLocalized(App\Localization\Languages::dateFormat()) }}</p>

        @include('components.tag-list', [
            'tags' => $story->tags,
        ])

    </div><!-- .container -->
@endsection

@section('main')
<div class="container">
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">

            <div class="content">
                {!! $story->html('content') !!}
            </div>
        </div><!-- .col -->
    </div><!-- .row -->
</div><!-- .container -->
@endsection
