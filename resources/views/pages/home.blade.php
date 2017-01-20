@extends('layouts.app', [
    'body_id' => 'home-page',
    'body_classes' => ['home-page', 'index-page'],
    'active_nav' => 'design',
])

@section('main')
    <header id="home-page-header" class="home-page-header">
        <div class="container">
            <h1>
                <small>{{ trans('brand.name') }}&mdash;{{ trans('brand.summary') }}</small><br>
                {{ trans('brand.mission') }}
            </h1>
            <a href="{{ url('designer/create') }}" class="btn btn-primary">
                <i class="fa fa-address-card"></i>
                Create Designer Profile
            </a>
            <a href="{{ url('place/create') }}" class="btn btn-default">
                <i class="fa fa-map-marker"></i>
                Mark Design Shop/Studio
            </a>
        </div>
    </header>

    <section id="designer-list" class="designer-list">
        <div class="container">
            @foreach ($designers as $designer)
                <article id="designer-{{ $designer->id }}" class="designer">
                    <header class="clearfix">
                        <a class="logo-wrap pull-left" href="{{ $designer->url }}">
                            @if ($designer->logo_id)
                                <img class="logo" src="{{ $designer->logo->small_file_url }}"/>
                            @endif
                        </a>

                        <h3 class="name">
                            <a href="{{ $designer->url }}">
                                {{ $designer->text('name') }}
                            </a>
                        </h3>

                        <p class="tagline text-muted">{{ $designer->text('tagline') }}</p>
                    </header>

                    <div class="image-gallery gallery">
                        @if ($designer->image_id)
                            <a class="cover-wrap image-wrap" href="{{ $designer->image->large_file_url }}">
                                <img class="cover image" src="{{ $designer->image->medium_file_url }}"/>
                            </a>
                        @endif
                        @foreach ($designer->gallery_images as $image)
                            <a class="image-wrap" href="{{ $image->large_file_url }}">
                                <img class="image" src="{{ $image->medium_file_url }}"/>
                            </a>
                        @endforeach
                    </div>
                    <div class="design-gallery gallery">
                        @foreach ($designer->designs as $design)
                            <a class="design-wrap image-wrap" href="{{ $design->url }}">
                                @if ($design->image_id)
                                    <img class="design-cover image" src="{{ $design->image->medium_file_url }}"/>
                                @endif
                                @if ($design->price && $design->currency)
                                    <span class="price">{{ $design->price . ' ' . $design->currency }}</span>
                                @endif
                            </a>
                        @endforeach
                    </div>
                    <footer class="text-center">
                        <a class="more-button btn btn-default btn-round" href="{{ $designer->url }}">
                            {{ trans('common.learn_more') }}
                        </a>
                    </footer>
                </article>
            @endforeach
        </div>
    </section>

@endsection
