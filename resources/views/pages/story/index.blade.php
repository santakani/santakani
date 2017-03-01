@extends('layouts.app', [
    'title' => trans('story.stories'),
    'body_id' => 'story-index-page',
    'body_classes' => ['story-index-page', 'story-page', 'index-page'],
    'active_nav' => 'story',
])

@section('main')

<header>

</header>

<div class="container">

    <h1 class="page-header">Stories</h1>
    <p class="lead">Share design skills, ideas and dreams.</p>

    <div class="row">
        <!-- article list -->
        <div class="col-md-8">

            @if (count($drafts))
                <p class="lead">{{ trans('story.my_drafts') }}</p>
                @each('components.cards.story-card', $drafts, 'story')

                <hr>
            @endif

            @each('components.cards.story-card', $stories, 'story')
            {!! $stories->appends(app('request')->all())->links() !!}
        </div>

        <!-- sidebar -->
        <div class="col-md-4 sticky">
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
