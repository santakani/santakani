@extends('layouts.app', [
    'title' => trans('story.stories'),
    'body_id' => 'story-index-page',
    'body_classes' => ['story-index-page', 'story-page', 'index-page'],
    'active_nav' => 'story',
])

@section('main')
    <section id="story-filter" class="article-filter">
        <form action="/story" method="get">
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
    </section><!-- #story-filter -->

    <section id="story-list" class="article-list">
        <div class="list">
            @foreach ($stories as $story)
                <article>
                    <a href="{{ $story->url }}">
                        <div class="cover">
                            @if ($story->image_id)
                                <img class="image" src="{{ $story->image->thumb_file_url }}"
                                    srcset="{{ $story->image->largethumb_file_url }} 2x"/>
                            @endif
                            @if ($story->logo_id)
                                <img class="logo" src="{{ $story->logo->small_file_url or '' }}"/>
                            @endif
                        </div>
                        <div class="text">
                            <div class="inner">
                                <h2>{{ $story->text('title') }}</h2>
                                <div class="tagline text-muted">{{ $story->text('tagline') }}</div>
                                <div class="excerpt">{{ $story->excerpt('content') }}</div>
                            </div>
                        </div>
                    </a>
                </article>
            @endforeach
        </div>
        <div class="pagination-wrap">
            {!! $stories->appends(app('request')->all())->links() !!}
        </div>
    </section><!-- #story-list -->
@endsection
