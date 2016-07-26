@extends('layouts.app', [
    'title' => trans('place.places'),
    'body_id' => 'place-index-page',
    'body_classes' => ['place-index-page', 'place-page', 'index-page'],
    'active_nav' => 'place',
    'has_footer' => false,
])

@section('main')
<div id="place-list" class="active">
    <div class="float-icon"><i class="fa fa-map-o"></i></div>
    <div class="container-fluid">

        <form id="place-filter" class="form" action="{{ url('place') }}" method="get">
            <div class="form-group">
                <label>{{ trans('geo.city') }}</label>
                @include('components.select.city', ['selected' => $city])
            </div>
            <div class="form-group">
                <label>{{ trans('common.type') }}</label>
                @include('components.place-type-select', [
                    'selected' => $type,
                    'all' => true,
                ])
            </div>
            <div class="form-group">
                <label>{{ trans('common.search') }}</label>
                <input type="search" name="search" value="{{ request()->input('search') }}"
                       class="form-control" maxlength="50"/>
            </div>
            <div class="form-group">
                <label>{{ trans('common.tag') }}</label>
                @include('components.tag-filter', ['selected' => request()->input('tag_id')])
            </div>
        </form>

        @foreach ($places as $place)
            <article id="place-{{ $place->id }}" class="place material-card"
                data-id="{{ $place->id }}" data-latitude="{{ $place->latitude }}"
                data-longitude="{{ $place->longitude }}"
                data-model="{{ $place->toJSON() }}">
                <a href="{{ $place->url }}">
                    <div class="cover-image" style="background-image:url({{ $place->image?$place->image->url('medium'):'' }})">
                        <span class="type">{{ $place->type }}</span>
                    </div>
                    <div class="text">
                        <h1 class="name">
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

<div id="place-map" data-latitude="{{ $city->latitude }}" data-longitude="{{ $city->longitude }}">
    <div class="float-icon"><i class="fa fa-list"></i></div>
</div>
@endsection
