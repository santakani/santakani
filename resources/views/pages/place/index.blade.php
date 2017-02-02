@extends('layouts.app', [
    'title' => trans('place.list_title', ['cityname' => $city->full_name]),
    'body_id' => 'place-index-page',
    'body_classes' => ['place-index-page', 'place-page', 'index-page'],
    'active_nav' => 'place',
    'has_footer' => false,
])

@section('main')
    <div id="place-map" data-latitude="{{ $city->latitude }}" data-longitude="{{ $city->longitude }}"></div>

    <div id="place-list">
        <form action="{{ url('place') }}" method="get">
            <div class="form-group">
                @include('components.select.city', ['selected' => $city])
            </div>
            <div class="form-group">
                @include('inputs.place-type', ['selected' => $type])
            </div>
            <div class="form-group">
                <input type="search" name="search" value="{{ request()->input('search') }}" id="place-search" class="form-control" maxlength="50" placeholder="{{ trans('common.search') }}" autocomplete="off" />
            </div>
            @include('inputs.tag-filter', ['selected' => request()->input('tag_id')])
        </form>

        <div class="list list-group">
            @forelse ($places as $place)
                <a href="{{ $place->url }}" class="place list-group-item clearfix" data-model="{{ $place->toJSON() }}">
                    @if ($place->image_id)
                        <img class="image pull-right" src="{{ $place->image->small_file_url }}" srcset="{{ $place->image->medium_file_url }} 2x"/>
                    @endif
                    <h3>
                        @if ($place->logo_id)
                            <img class="logo" src="{{ $place->logo->small_file_url }}"/>
                        @endif
                        {{ $place->name }}
                    </h3>

                    <p>{{ $place->address }}</p>

                    {{ $place->text('tagline') }}
                </a>
            @empty
                <p class="lead text-center">{{ trans('place.no_place_found') }}</p>
            @endforelse
            {!! $places->appends(app('request')->all())->links() !!}
        </div><!-- .list -->

    </div><!-- #place-list -->

@endsection
