@extends('layout.app', [
    'title' => $place->text('name') . ' - Place',
    'body_id' => 'place-show-page',
    'body_classes' => ['place-show-page', 'place-page', 'show-page'],
    'active_nav' => 'place',
])

@section('header')
<header>
    <div class="container">
        <div class="gallery clearfix">
            @if ($place->image)
                <a href="{{ $place->image->file_urls['large'] }}">
                    <img src="{{ $place->image->file_urls['thumb'] }}">
                </a>
            @else
                <a class="placeholder" href="#">
                    <img src="http://placehold.it/300x300?text=NO+IMAGE">
                </a>
            @endif
            @forelse ($place->gallery_images as $image)
                @if ($image->id !== $place->image_id)
                    <a href="{{ $image->file_urls['large'] }}">
                        <img src="{{ $image->file_urls['thumb'] }}">
                    </a>
                @endif
            @empty
                @for ($i = 0; $i < 8; $i++)
                    <a class="placeholder" href="#">
                        <img src="http://placehold.it/300x300?text=NO+IMAGE">
                    </a>
                @endfor
            @endforelse
        </div>
        <h1 class="page-header">
            {{ $place->text('name') }}
            <small>{{ $place->city->text('name') }}, {{ $place->country->text('name') }}</small>

            @if ($can_edit)
                <div class="pull-right hidden-xs">
                    <a id="edit-button" class="btn btn-sm btn-default" href="{{ $place->url . '/edit' }}">Edit</a>
                    <a id="delete-button" class="btn btn-sm btn-danger" href="#">Delete</a>
                </div>
            @endif
        </h1>
    </div>
</header>
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
