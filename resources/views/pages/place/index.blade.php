@extends('layouts.app', [
    'title' => trans('place.list_title', ['cityname' => $city->full_name]),
    'body_id' => 'place-index-page',
    'body_classes' => ['place-index-page', 'place-page', 'index-page'],
    'active_nav' => 'place',
    'has_footer' => false,
])

@section('main')

    <div id="place-list">

        <form class="form-inline" action="{{ url('place') }}" method="get">
            <div class="city-search">
                @include('components.selects.city-select', ['selected' => $city])
                <input type="search" name="search" value="{{ request()->input('search') }}" id="place-search" class="search-input form-control" maxlength="50" placeholder="&#xf4a4; {{ trans('common.search') }}" autocomplete="off" />
            </div>
            @include('components.tags.tag-filter', ['selected' => request()->input('tag_id'), 'class' => 'hidden-xs'])
        </form>

        <div class="list hidden-xs">
            @forelse ($places as $place)
                @include('components.cards.place-card', ['place' => $place, 'hide_city' => true, 'with_data' => true])
            @empty
                <p class="lead text-center">{{ trans('place.no_place_found') }}</p>
            @endforelse
            {!! $places->appends(app('request')->all())->links() !!}
        </div><!-- .list -->

    </div><!-- #place-list -->

    <div id="place-map" data-latitude="{{ $city->latitude }}" data-longitude="{{ $city->longitude }}"></div>

@endsection
