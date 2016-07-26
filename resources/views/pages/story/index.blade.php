@extends('layouts.app', [
    'title' => trans('story.stories'),
    'body_id' => 'story-index-page',
    'body_classes' => ['story-index-page', 'story-page', 'index-page'],
    'active_nav' => 'story',
])

@section('main')
<div class="container">
    <form id="story-filter" class="list-filter" action="/story" method="get">
        <div class="form-group">
            <label>{{ trans('common.search') }}</label>
            <input type="search" name="search" value="{{ request()->input('search') }}"
                   class="form-control" placeholder="{{ trans('common.search') }}"
                   maxlength="50"/>
        </div>
        <div class="form-group">
            <label>{{ trans('common.tag') }}</label>
            @include('components.tag-filter', ['selected' => request()->input('tag_id')])
        </div>
    </form>
    <div id="story-list" class="story-list row">
        @foreach ($stories as $story)
            <div class="col-sm-4 col-lg-3">
                <article id="story-{{ $story->id }}" class="story material-card" data-id="{{ $story->id }}">
                    <a href="{{ $story->url }}">
                        @if ($image = $story->image)
                            <img class="cover-image" src="{{ $image->url('thumb') }}" />
                        @else
                            <img class="cover-image" src="http://placehold.it/300x300?text=NO+IMAGE" />
                        @endif
                        <div class="shadow"></div>
                        <div class="text">
                            <h1>{{ $story->title }}</h1>
                            {{ $story->excerpt('content') }}
                        </div>
                    </a>
                </article>
            </div>
        @endforeach
    </div><!-- #story-list -->
    <div class="text-center">
        {!! $stories->appends(app('request')->all())->links() !!}
    </div>
</div><!-- .container -->
@endsection
