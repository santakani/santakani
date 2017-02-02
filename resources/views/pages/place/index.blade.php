@extends('layouts.app', [
    'title' => trans('place.list_title', ['cityname' => $city->full_name]),
    'body_id' => 'place-index-page',
    'body_classes' => ['place-index-page', 'place-page', 'index-page'],
    'active_nav' => 'place',
    'has_footer' => false,
])

@section('main')
    <div id="place-list" class="active">
        <div class="float-icon"><span class="stroke-icon icon-place"></span></div>

        <section id="place-filter" class="article-filter">
            <form action="{{ url('place') }}" method="get">
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
                           id="place-search" class="form-control" maxlength="50"/>
                </div>
                <div class="form-group">
                    <label>{{ trans('common.tag') }}</label>
                    @include('components.tag-filter', ['selected' => request()->input('tag_id')])
                </div>
            </form>
        </section><!-- .article-filter -->

        <section class="article-list">
            <div class="list">
                @foreach ($places as $place)
                    <article data-model="{{ $place->toJSON() }}">
                        <a href="{{ $place->url }}">
                            <div class="cover">
                                @if ($place->image_id)
                                    <img class="image" src="{{ $place->image->thumb_file_url }}"
                                        srcset="{{ $place->image->largethumb_file_url }} 2x"/>
                                @else
                                    <img class="image" src="{{ url('img/placeholder/square.png') }}"/>
                                @endif
                                @if ($place->logo_id)
                                    <img class="logo" src="{{ $place->logo->small_file_url }}"/>
                                @endif
                            </div>
                            <div class="text">
                                <div class="inner">
                                    <h3>{{ $place->name }} <small>{{ $place->address }}</small></h3>

                                    <p class="excerpt">{{ $place->excerpt('content') }}</p>
                                </div>
                            </div>
                        </a>
                    </article>
                @endforeach
            </div><!-- .list -->
            <div class="pagination-wrap">
                {!! $places->appends(app('request')->all())->links() !!}
            </div>
        </section><!-- .article-list -->
    </div><!-- #place-list -->

<div id="place-map" data-latitude="{{ $city->latitude }}" data-longitude="{{ $city->longitude }}">
    <div class="float-icon"><span class="stroke-icon icon-list"></span></div>
</div>
@endsection
