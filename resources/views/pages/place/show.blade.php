@extends('layouts.app', [
    'title' => $place->text('name') . ' - Place',
    'body_id' => 'place-show-page',
    'body_classes' => ['place-show-page', 'place-page', 'show-page'],
    'active_nav' => 'place',
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
                    <img class="cover-image image" src="{{ $place->image->url('thumb') }}"
                        data-src="{{ $place->image->url('large') }}" width="300" height="300"/>
                    <div class="raster"></div>
                </div><!-- /.image-wrap -->
            @else
                <img class="cover-image placeholder" src="{{ url('img/placeholder/blank/300x300.svg') }}">
            @endif
            @foreach ($place->gallery_images as $image)
                {{-- Ignore cover image --}}
                @if ($image->id !== $place->image_id)
                    <div class="image-wrap">
                        <img class="image" src="{{ $image->url('thumb') }}"
                            data-src="{{ $image->url('large') }}" width="300" height="300"/>
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
            @include('components.tag-list', [
                'tags' => $place->tags,
                'style' => 'plain',
            ])
            {!! $place->text('content') !!}
        </div>
        <div class="col-sm-6 col-md-4">
            <h4>Location</h4>

            <p>{{ $place->address }}<br>{{ $place->city->text('name') }}, {{ $place->country->text('name') }}</p>

            <div class="map" data-latitude="{{ $place->latitude }}" data-longitude="{{ $place->longitude }}"></div>

            <h4>Contact</h4>
            <ul class="list-unstyled">
            <li>Phone: {{ $place->phone or '-' }}</li>
            <li>Email: {{ $place->email or '-' }}</li>
            </ul>

            <h4>Links</h4>
            <ul class="list-unstyled">
                @if ($place->website)
                    <li><a href="{{ $place->website }}">Website</a></li>
                @endif
                @if ($place->facebook)
                    <li><a href="{{ $place->facebook }}">Facebook</a></li>
                @endif
                @if ($place->google_plus)
                    <li><a href="{{ $place->google_plus }}">Google+</a></li>
                @endif
            </ul>
        </div>
    </div>
</div>
@endsection
