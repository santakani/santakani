@extends('layouts.app', [
    'body_id' => 'search-page',
    'body_classes' => ['search-page', 'search-page'],
    'active_nav' => 'search',
])

@section('main')

<header id="search-header">
    <div class="container">

        <form class="search-form" action="{{ url('search') }}" method="get">
            <input class="form-control input-lg" type="search" name="query" value="{{ $query }}" placeholder="&#xf4a4; {{ trans('common.search') }}" required>
        </form>

        <ul class="nav nav-tabs nav-justified">
            <li class="{{ $type==='design'?'active':'' }}">
                <a href="{{ action('SearchController@index', ['query' => $query, 'type' => 'design']) }}">{{ trans('design.designs') }}
                <span class="badge">{{ $result_counts['design'] }}</span></a>
            </li>
            <li class="{{ $type==='designer'?'active':'' }}">
                <a href="{{ action('SearchController@index', ['query' => $query, 'type' => 'designer']) }}">
                    {{ trans('designer.designers') }}
                    <span class="badge">{{ $result_counts['designer'] }}</span>
                </a>
            </li>
            <li class="{{ $type==='place'?'active':'' }}">
                <a href="{{ action('SearchController@index', ['query' => $query, 'type' => 'place']) }}">
                    {{ trans('place.places') }}
                    <span class="badge">{{ $result_counts['place'] }}</span>
                </a>
            </li>
            <li class="{{ $type==='story'?'active':'' }}">
                <a href="{{ action('SearchController@index', ['query' => $query, 'type' => 'story']) }}">
                    {{ trans('story.stories') }}
                    <span class="badge">{{ $result_counts['story'] }}</span>
                </a>
            </li>
            <li class="{{ $type==='user'?'active':'' }}">
                <a href="{{ action('SearchController@index', ['query' => $query, 'type' => 'user']) }}">
                    {{ trans('common.users') }}
                    <span class="badge">{{ $result_counts['user'] }}</span>
                </a>
            </li>
        </ul>

    </div><!-- /.container -->
</header>

<div id="search-results">
    <div class="container">
        @if ($type === 'design')
            <div class="row">
                @foreach ($results as $design)
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        @include('components.cards.design-card', ['design' => $design])
                    </div>
                @endforeach
            </div>
        @endif

        @if ($type === 'designer')
            <div class="row">
                @foreach ($results as $designer)
                    <div class="col-sm-6 col-lg-4">
                        @include('components.cards.designer-card', ['designer' => $designer])
                    </div>
                @endforeach
            </div>
        @endif

        @if ($type === 'place')
            @foreach ($results as $place)
                {{ $place->text('name') }}
            @endforeach
        @endif

        @if ($type === 'story')
            @each('components.cards.story-card', $results, 'story')
        @endif

        @if ($type === 'user')
            <div class="row">
                @foreach ($results as $user)
                    <div class="col-sm-6 col-lg-4">
                        @include('components.cards.user-card', ['user' => $user])
                    </div>
                @endforeach
            </div>
        @endif

        {{ $results->appends(app('request')->all())->links() }}
    </div><!-- /.container -->
</div><!-- /#search-results -->

@endsection
