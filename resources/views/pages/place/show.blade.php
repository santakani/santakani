@extends('layouts.app', [
    'title' => $place->text('name') . ' - ' . trans('place.'.$place->type) . ' - ' . trans('place.place'),
    'body_id' => 'place-show-page',
    'body_classes' => ['place-show-page', 'place-page', 'show-page'],
    'active_nav' => 'place',
    'og_title' => $place->text('name'),
    'og_url' => $place->url,
    'og_description' => $place->excerpt('content'),
    'og_image' => empty($place->image_id)?'':$place->image->fileUrl('medium'),
    'has_share_buttons' => true,
])

@section('header')
    <div class="page-cover"
        @if ($place->image_id)
            style="background-image:url({{ $place->image->large_file_url }})"
        @endif
        >

        <div class="raster raster-dark-dot"></div>

        <div class="type type-{{ $place->type }}">{{ trans('place.'.$place->type) }}</div>

        <div class="buttons">
            @include('components.buttons.like', ['likeable' => $place])
            @if (Auth::check())
                @if (Auth::user()->can('edit-designer', $place))
                    @include('components.buttons.edit')
                @endif
                @if (Auth::user()->can('delete-designer', $place))
                    @include('components.buttons.delete')
                @endif
            @endif
        </div><!-- /.buttons -->

        @if ($place->logo_id)
            <img class="logo" src="{{ $place->logo->small_file_url }}"/>
        @endif

        <h1 class="name">{{ $place->text('name') }}</h1>
        <p class="address">{{ $place->full_address }}</p>

        <div class="links">
            @if (!empty($place->facebook))
                <a href="{{ $place->facebook }}" title="Facebook">
                    <i class="fa fa-facebook-official"></i>
                </a>
            @endif
            @if (!empty($place->twitter))
                <a href="{{ $place->twitter }}" title="Twitter">
                    <i class="fa fa-twitter"></i>
                </a>
            @endif
            @if (!empty($place->google_plus))
                <a href="{{ $place->google_plus }}" title="Google+">
                    <i class="fa fa-google-plus"></i>
                </a>
            @endif
            @if (!empty($place->instagram))
                <a href="{{ $place->instagram }}" title="Instagram">
                    <i class="fa fa-instagram"></i>
                </a>
            @endif
            @if (!empty($place->email))
                <a href="mailto:{{ $place->email }}" title="{{ trans('common.email') }}">
                    <i class="fa fa-envelope-o"></i>
                </a>
            @endif
            @if (!empty($place->email))
                <a href="{{ $place->website }}" title="{{ trans('common.website') }}">
                    <i class="fa fa-globe"></i>
                </a>
            @endif
        </div>

        @include('components.tag-list', ['tags' => $place->tags])

    </div><!-- /.page-cover -->
@endsection

@section('main')
    <div class="gallery-slider-wrap">
        <ul id="gallery" class="gallery gallery-slider">
            @foreach ($place->gallery_images as $image)
                <li data-src="{{ $image->large_file_url }}">
                    <img class="image" src="{{ $image->thumb_file_url }}"  width="300" height="300"/>
                </li>
            @endforeach
        </ul>
    </div>

    <br>

<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-8">
            {!! $place->html('content') !!}
        </div>
        <div class="col-sm-6 col-md-4">

            <ul class="list-inline">
                <li><a href="{{ $place->google_map_url }}" target="_blank">
                    {{ trans('geo.google_map') }} <i class="fa fa-external-link"></i>
                </a></li>
                <li><a href="{{ $place->bing_map_url }}" target="_blank">
                    {{ trans('geo.bing_map') }} <i class="fa fa-external-link"></i>
                </a></li>
                <li><a href="{{ $place->here_map_url }}" target="_blank">
                    {{ trans('geo.here_map') }} <i class="fa fa-external-link"></i>
                </a></li>
            </ul>

            <div class="map"
                 data-latitude="{{ $place->latitude }}"
                 data-longitude="{{ $place->longitude }}"
                 data-address="{{ $place->full_address }}"></div>

            <br>

            <ul class="list-unstyled">
                <li><i class="fa fa-fw fa-phone"></i> {{ $place->phone or '-' }}</li>
                <li><i class="fa fa-fw fa-envelope-o"></i> {{ $place->email or '-' }}</li>
            </ul>
        </div>
    </div>
</div>
@endsection
