@extends('layouts.app', [
    'title' => trans('story.stories'),
    'body_id' => 'story-index-page',
    'body_classes' => ['story-index-page', 'story-page', 'index-page'],
    'active_nav' => 'story',
])

@section('main')

<div class="container">

    <h1 class="page-header">Stories</h1>
    <p class="lead">Share design skills, ideas and dreams.</p>

    <div class="row">
        <!-- article list -->
        <div class="col-sm-8">
            @foreach ($stories as $story)
                <article class="story panel panel-default">
                    <div class="clearfix panel-body" href="{{ $story->url }}">
                        @if ($story->image)
                            <a href="{{ $story->url }}">
                                <img class="pull-right" src="{{ $story->image->small_file_url }}" srcset="{{ $story->image->medium_file_url }} 2x"/>
                            </a>
                        @endif
                        <h2><a href="{{ $story->url }}">{{ $story->text('title') }}</a></h2>
                        <p class="excerpt">{{ $story->excerpt('content') }}</p>
                    </div>
                    <footer class="panel-footer text-muted">
                        <ul class="list-inline">
                            <li>
                                <a href="{{ $story->user->url }}">
                                    <img class="avatar" src="{{ $story->user->small_avatar_url }}" width="25" height="25">
                                    {{ $story->user->name }}
                                </a>
                            </li>
                            <li>{{ $story->created_at->toDateString() }}</li>
                            <li><i class="fa fa-lg fa-heart-o"></i> {{ $story->like_count }}</li>
                        </ul>
                    </footer>
                </article>
            @endforeach

            {!! $stories->appends(app('request')->all())->links() !!}
        </div>

        <!-- sidebar -->
        <div class="col-sm-4 sticky">
            <sidebar>
                <form class="form" action="/story" method="get">
                    <input type="search" name="search" value="{{ request('search') }}" class="form-control" placeholder="{{ trans('common.search') }}" maxlength="50"/>
                </form>

                <br><br>

                <div class="list-group">
                    <a class="list-group-item {{ request('tag_id')?'':'active' }}" href="/story">
                        <span class="badge">{{ App\Story::count() }}</span>
                        {{ trans('common.all') }}
                    </a>
                    @foreach (App\Tag::take(10)->orderBy('level', 'desc')->orderBy('id')->get() as $tag)
                        <a class="list-group-item {{ request('tag_id')==$tag->id?'active':'' }}" href="/story?tag_id={{ $tag->id }}">
                            <span class="badge">{{ $tag->stories()->count() }}</span>
                            {{ $tag->text('name') }}
                        </a>
                    @endforeach
                </div>
            </sidebar>
        </div>
    </div>

</div>

@endsection
