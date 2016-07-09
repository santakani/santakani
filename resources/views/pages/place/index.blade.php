@extends('layouts.app', [
    'title' => 'Places',
    'body_id' => 'place-index-page',
    'body_classes' => ['place-index-page', 'place-page', 'index-page'],
    'active_nav' => 'place',
])

@section('main')
<div id="place-map" data-latitude="{{ $city->latitude }}" data-longitude="{{ $city->longitude }}"></div>

<div id="place-list">
    <div class="container-fluid">

        <form id="place-filter" class="form" action="{{ url('place') }}" method="get" autocomplete="off">
            <div class="form-group">
                <label>{{ trans('geo.city') }}</label>
                <select name="city_id" id="city-select" class="city-select form-control">
                    @if (!empty($city))
                        <option value="{{ $city->id }}" selected="selected">
                            {{ $city->full_name }}
                        </option>
                    @endif
                </select>
            </div>
            <div class="form-group">
                <label>{{ trans('common.type') }}</label>
                @include('components.place-type-select', [
                    'selected' => $type,
                    'all' => true,
                ])
            </div>
            <div class="form-group">
                <label>{{ trans('common.tag') }}</label>
                @include('components.tag-filter', ['selected' => app('request')->input('tag_id')])
            </div>
        </form>

        @foreach ($places as $place)
            <article id="place-{{ $place->id }}" class="place material-card"
                data-id="{{ $place->id }}" data-latitude="{{ $place->latitude }}"
                data-longitude="{{ $place->longitude }}">
                <a href="{{ $place->url }}">
                    <div class="cover-image" style="background-image:url({{ $place->image?$place->image->url('medium'):'' }})">
                        <span class="type">{{ $place->type }}</span>
                    </div>
                    <div class="text">
                        <h1 class="name">
                            <span class="dot"></span>
                            {{ $place->text('name') }}
                            <small>
                                {{ $place->address }}
                            </small>
                        </h1>
                        <div class="excerpt">
                            {{ $place->excerpt('content') }}
                        </div>
                    </div>
                </a>
            </article>
        @endforeach
    </div>
    <div class="text-center">
        {!! $places->links() !!}
    </div>
</div><!-- #place-list -->
@endsection
