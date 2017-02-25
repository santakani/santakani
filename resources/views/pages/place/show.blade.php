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
])

{{--
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
--}}

@section('main')

<header>
    <div class="container">
        <div class="row no-gutter">
            <div class="col-sm-8 col-md-6">
                @if ($place->image_id)
                    <img class="cover" src="{{ $place->image->banner_file_url }}">
                @else
                    <img class="cover" src="{{ url('img/placeholder/banner.svg') }}">
                @endif
            </div>
            <div class="col-sm-4 col-md-6">
                @include('components.maps.simple-map', ['place' => $place])
            </div>
        </div>

        <h1 class="title">
            {{ $place->text('name') }}
            @include('pages.place.show-action-bar')
        </h1>

        <ul class="metadata list-inline text-muted">
            <li>{{ $place->address }}</li>
            @if ($place->city_id)
                <li>{{ $place->city->full_name }}</li>
            @endif
            <li>{{ trans_choice('common.like_count', $place->like_count) }}</li>
        </ul>

    </div><!-- /.container -->
</header>

<div class="container">

    <div class="row">
        <div class="col-sm-6 col-md-8">
            {!! $place->html('content') !!}
        </div>
        <div class="col-sm-6 col-md-4">

            @include('components.social-links', ['model' => $place])

            @include('components.tags.tags-hash', ['tags' => $place->tags, 'linked' => true])

        </div>
    </div>

    <h2>{{ trans('common.gallery') }}</h2>

    <div class="images">
        @foreach ($place->gallery_images as $image)
            <a href="{{ $image->large_file_url }}">
                <img class="image" src="{{ $image->thumb_file_url }}"  width="300" height="300"/>
            </a>
        @endforeach
    </div>

</div>

@endsection

@if (Auth::check() && Auth::user()->can('edit-place', $place))
    @push('modals')
        @include('components.modals.transfer-modal', ['user' => $place->user])
    @endpush
@endif
