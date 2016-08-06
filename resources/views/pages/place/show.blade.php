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
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <h1>{{ $place->text('name') }}</h1>
            </div>
            <div class="col-sm-6">
                <h1>
                    <div class="action-buttons right-sm">
                        @include('components.buttons.like', ['likeable' => $place])
                        @if (Auth::check())
                            @if (Auth::user()->can('edit-place', $place))
                                @include('components.buttons.edit')
                            @endif
                            @if (Auth::user()->can('delete-place', $place))
                                @include('components.buttons.delete')
                            @endif
                        @endif
                    </div><!-- /.action-buttons -->
                </h1>
            </div>
        </div><!-- /.row -->

        <div id="gallery" class="gallery clearfix">
            @if ($place->image_id)
                <div class="image-wrap">
                    <img class="cover-image image" src="{{ $place->image->fileUrl('thumb') }}"
                        data-src="{{ $place->image->fileUrl('large') }}" width="300" height="300"/>
                    <div class="raster"></div>
                </div><!-- /.image-wrap -->
            @else
                <img class="cover-image placeholder" src="{{ url('img/placeholder/blank/300x300.svg') }}">
            @endif
            @foreach ($place->gallery_images as $image)
                {{-- Ignore cover image --}}
                @if ($image->id !== $place->image_id)
                    <div class="image-wrap">
                        <img class="image" src="{{ $image->fileUrl('thumb') }}"
                            data-src="{{ $image->fileUrl('large') }}" width="300" height="300"/>
                        <div class="raster"></div>
                    </div><!-- /.image-wrap -->
                @endif
            @endforeach
        </div><!-- /#gallery -->
    </div><!-- /.container -->
@endsection

@section('main')
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-8">
            {!! $place->html('content') !!}
        </div>
        <div class="col-sm-6 col-md-4">
            <h4>{{ trans('common.tags') }}</h4>
            @include('components.tag-list', [
                'tags' => $place->tags,
                'style' => 'plain',
            ])

            <h4>{{ trans('geo.location') }}</h4>

            <p>{{ $place->full_address }}</p>
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

            <h4>{{ trans('common.contact') }}</h4>
            <ul class="list-unstyled">
                <li><i class="fa fa-fw fa-phone"></i> {{ $place->phone or '-' }}</li>
                <li><i class="fa fa-fw fa-envelope-o"></i> {{ $place->email or '-' }}</li>
            </ul>

            <h4>{{ trans('common.links') }}</h4>
            <ul class="list-unstyled">
                @if ($place->website)
                    <li><i class="fa fa-fw fa-globe"></i> <a href="{{ $place->website }}">Website</a></li>
                @endif
                @if ($place->facebook)
                    <li><i class="fa fa-fw fa-facebook-square"></i> <a href="{{ $place->facebook }}">Facebook</a></li>
                @endif
                @if ($place->google_plus)
                    <li><i class="fa fa-fw fa-google-plus-square"></i> <a href="{{ $place->google_plus }}">Google+</a></li>
                @endif
            </ul>
        </div>
    </div>
</div>
@endsection
