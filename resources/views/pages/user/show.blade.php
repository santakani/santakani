@extends('layouts.app', [
    'title' => $user->name . ' - ' . trans('common.user'),
    'body_id' => 'user-show-page',
    'body_classes' => ['user-show-page', 'user-page', 'show-page'],
    'og_title' => $user->name,
    'og_url' => $user->url,
    'og_description' => $user->description,
    'og_image' => $user->large_avatar_url,
])

@section('header')
    <div class="article-list-header">
        <div class="container">
            <img class="avatar" src="{{ $user->medium_avatar_url }}"
                srcset="{{ $user->large_avatar_url }} 2x" width="150" height="150"/>
            <div class="text">
                <h1 class="user-name">
                    {{ $user->name }}
                    @if (Auth::user()->id === $user->id)
                        <a class="btn btn-default" href="/setting/profile">
                            <i class="fa fa-pencil"></i>
                            {{ trans('common.edit') }}
                        </a>
                    @endif
                </h1>
                <p class="description">
                    @if ($user->description)
                        {{ $user->description }}
                    @else
                        No description.
                    @endif
                    @if (Auth::user()->id === $user->id)
                        <a href="/setting/profile">
                            <i class="fa fa-pencil"></i>
                            {{ trans('common.edit') }}
                        </a>
                    @endif
                </p>
                @if ($user->created_at)
                    <p class="date">{{ $user->created_at->formatLocalized(App\Localization\Languages::dateFormat()) }}</p>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('main')
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
                        </div>
                        <div class="text">
                            <div class="inner">
                                <h3>{{ $story->title }}</h3>
                                <p class="excerpt">{{ $story->excerpt('content') }}</p>
                            </div>
                        </div>
                    </a>
                </article>
            @endforeach
        </div>
        <div class="pagination-wrap">
            {!! $stories->appends(app('request')->all())->links() !!}
        </div>
    </section>
@endsection
