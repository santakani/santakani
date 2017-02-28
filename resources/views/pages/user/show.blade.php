@extends('layouts.app', [
    'title' => $user->name . ' - ' . trans('common.user'),
    'body_id' => 'user-show-page',
    'body_classes' => ['user-show-page', 'user-page', 'show-page'],
    'og_title' => $user->name,
    'og_url' => $user->url,
    'og_description' => $user->description,
    'og_image' => $user->large_avatar_url,
])

@section('main')

<div class="container">
    <div class="row">
        <div class="col-md-3">
            <img class="avatar image-responsive" src="{{ $user->large_avatar_url }}" width="300" height="300"/>
            <h1 class="user-name">
                {{ $user->name }}
            </h1>
            <p class="description">
                @if ($user->description)
                    {!! nl2br(htmlspecialchars($user->description)) !!}
                @else
                    No description.
                @endif
            </p>
            @if ($user->created_at)
                <p class="date">{{ $user->created_at->formatLocalized(App\Localization\Languages::dateFormat()) }}</p>
            @endif

            @if (Auth::check() && Auth::user()->id === $user->id)
                <a class="btn btn-default btn-block btn-lg" href="/setting/profile">
                    <i class="ion-ios-compose-outline"></i>
                    {{ trans('common.edit') }}
                </a>
            @endif
        </div><!-- /.col-* -->
        <div class="col-md-9">
            <ul id="tabs" class="nav nav-tabs nav-justified">
                <li class="{{ $tab === 'overview' ? 'active' : '' }}">
                    <a href="{{ $user->url }}">{{ trans('common.overview') }}</a>
                </li>
                <li class="{{ $tab === 'stories' ? 'active' : '' }}">
                    <a href="{{ $user->url }}?tab=stories">
                        {{ trans('story.stories') }}
                        <span class="badge hidden-xs">{{ $user->stories()->count() }}</span>
                    </a>
                </li>
                <li class="{{ $tab === 'likes' ? 'active' : '' }}">
                    <a href="{{ $user->url }}?tab=likes">
                        {{ trans_choice('common.like_noun', 10) }}
                        <span class="badge hidden-xs">{{ $user->likes()->count() }}</span>
                    </a>
                </li>
            </ul>

            @if ($tab === 'stories')
                @each('components.cards.story-card', $stories, 'story')
            @elseif ($tab === 'likes')
                <ul id="like-types" class="nav nav-pills">
                    <li role="presentation" class="{{ $type === 'design' ? 'active' : '' }}"><a href="{{ $user->url }}?tab=likes&amp;type=design">{{ trans('design.design') }}</a></li>
                    <li role="presentation" class="{{ $type === 'designer' ? 'active' : '' }}"><a href="{{ $user->url }}?tab=likes&amp;type=designer">{{ trans('designer.designer') }}</a></li>
                    <li role="presentation" class="{{ $type === 'place' ? 'active' : '' }}"><a href="{{ $user->url }}?tab=likes&amp;type=place">{{ trans('place.place') }}</a></li>
                    <li role="presentation" class="{{ $type === 'story' ? 'active' : '' }}"><a href="{{ $user->url }}?tab=likes&amp;type=story">{{ trans('story.story') }}</a></li>
                </ul>

                @if ($type === 'design')
                    <div class="row">
                        @foreach ($likes as $design)
                            <div class="col-sm-6 col-md-4">
                                @include('components.cards.design-card', ['design' => $design])
                            </div>
                        @endforeach
                    </div>
                @elseif ($type === 'designer')
                    <div class="row">
                        @foreach ($likes as $designer)
                            <div class="col-sm-6 col-md-4">
                                @include('components.cards.designer-card', ['designer' => $designer])
                            </div>
                        @endforeach
                    </div>
                @elseif ($type === 'place')
                    <div class="row">
                        @foreach ($likes as $place)
                            <div class="col-sm-6 col-lg-4">
                                @include('components.cards.place-card', ['place' => $place])
                            </div>
                        @endforeach
                    </div>
                @elseif ($type === 'story')
                    @each('components.cards.story-card', $likes, 'story')
                @endif

                <div class="text-center">{{ $likes->appends(app('request')->all())->links() }}</div>
            @else
                @if (count($stories))
                    <h2>{{ trans('story.stories') }}</h2>

                    @each('components.cards.story-card', $stories, 'story')

                    <div class="text-right">
                        <a class="btn btn-link" href="{{ $user->url }}?tab=stories">
                            {{ trans('common.more') }}...
                        </a>
                    </div>
                @endif

                @if (count($likes))
                    <h2>{{ trans_choice('common.like_noun', count($likes)) }}</h2>

                    <div class="row">
                        @foreach ($likes as $like)
                            <div class="col-sm-6 col-md-4">
                                @include('components.cards.'.$like->likeable_type.'-card', [$like->likeable_type => $like->likeable])
                            </div>
                        @endforeach
                    </div>

                    <div class="text-right">
                        <a class="btn btn-link" href="{{ $user->url }}?tab=likes">
                            {{ trans('common.more') }}...
                        </a>
                    </div>
                @endif

                @if (count($designers))
                    <h2>{{ trans('designer.designers') }}</h2>

                    <div class="row">
                        @foreach ($designers as $designer)
                            <div class="col-sm-6 col-md-4">
                                @include('components.cards.designer-card', ['designer' => $designer])
                            </div><!-- /.col -->
                        @endforeach
                    </div><!-- /.row -->
                @endif

                @if (count($places))
                    <h2>{{ trans('place.places') }}</h2>

                    <div class="row">
                        @foreach ($places as $place)
                            <div class="col-sm-6 col-md-4">
                                @include('components.cards.place-card', ['place' => $place])
                            </div><!-- /.col -->
                        @endforeach
                    </div><!-- /.row -->
                @endif
            @endif
        </div><!-- /.col-* -->
    </div><!-- /.row -->
</div><!-- /.container -->

@endsection
