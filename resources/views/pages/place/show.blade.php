@extends('layouts.app', [
    'title' => $place->text('name') . ' - ' . trans('place.'.$place->type) . ' - ' . trans('place.place'),
    'body_id' => 'place-show-page',
    'body_classes' => ['place-show-page', 'place-page', 'show-page'],
    'active_nav' => 'place',
    'og_title' => $place->text('name'),
    'og_url' => $place->url,
    'og_description' => $place->excerpt('content'),
    'og_image' => empty($place->image_id)?'':$place->image->fileUrl('medium'),
    'twitter_card_type' => 'summary_large_image',
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
            @if (Auth::check() && Auth::user()->can('edit-place', $place))
                <div class="btn-group">
                    <a id="edit-button" class="btn btn-default" href="{{ url()->current() . '/edit' }}">
                        <i class="fa fa-lg fa-pencil"></i> {{ trans('common.edit') }}
                    </a>
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-lg fa-ellipsis-v"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right">
                        @if (Auth::user()->can('transfer-place', $place))
                            <li><a id="transfer-button" href="#" data-toggle="modal" data-target="#transfer-modal"><i class="fa fa-fw fa-exchange"></i> {{ trans('common.transfer') }}</a></li>
                        @endif
                        @if (Auth::user()->can('delete-place', $place))
                            <li><a id="delete-button" href="#"><i class="fa fa-fw fa-trash"></i> {{ trans('common.delete') }}</a></li>
                            @if (Auth::user()->role === 'admin' || Auth::user()->role === 'editor')
                                <li><a id="force-delete-button" href="#"><i class="fa fa-fw fa-ban"></i> {{ trans('common.delete_permanently') }}</a></li>
                            @endif
                        @endif
                    </ul>
                </div><!--/.btn-group -->
            @endif
        </div><!-- /.buttons -->

        @if ($place->logo_id)
            <img class="logo" src="{{ $place->logo->small_file_url }}"/>
        @endif

        <h1 class="name">{{ $place->text('name') }}</h1>
        <p class="address">{{ $place->full_address }}</p>

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

            <h3>{{ trans('geo.location') }}</h3>

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

            <h3>{{ trans('common.links') }}</h3>

            <ul class="link-list">
                @if (!empty($place->facebook))
                    <li>
                        <a href="{{ $place->facebook }}">
                            <i class="fa fa-fw fa-2x fa-facebook-official"></i> Facebook
                        </a>
                    </li>
                @endif
                @if (!empty($place->twitter))
                    <li>
                        <a href="{{ $place->twitter }}">
                            <i class="fa fa-fw fa-2x fa-twitter"></i> Twitter
                        </a>
                    </li>
                @endif
                @if (!empty($place->instagram))
                    <li>
                        <a href="{{ $place->instagram }}">
                            <i class="fa fa-fw fa-2x fa-instagram"></i> Instagram
                        </a>
                    </li>
                @endif
                @if (!empty($place->website))
                    <li>
                        <a href="{{ $place->website }}">
                            <i class="fa fa-fw fa-2x fa-globe"></i> {{ trans('common.website') }}
                        </a>
                    </li>
                @endif
            </ul>

            <h3>{{ trans('common.contact') }}</h3>

            @if (!empty($place->email))
                <p>
                    <a href="mailto:{{ $place->email }}">
                        {{ $place->email }}
                    </a>
                </p>
            @endif
            @if (!empty($place->phone))
                <p>
                    <a href="tel:{{ $place->phone }}">
                        {{ $place->phone }}
                    </a>
                </p>
            @endif
        </div>
    </div>
</div>
@endsection

@if (Auth::check() && Auth::user()->can('edit-place', $place))
    @push('modals')
        @include('components.modals.transfer-modal', ['user' => $place->user])
    @endpush
@endif
