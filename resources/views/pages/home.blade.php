@extends('layouts.app', [
    'body_id' => 'home-page',
    'body_classes' => ['home-page', 'index-page'],
    'active_nav' => 'design',
])

@section('main')
    <header id="home-page-header" class="home-page-header {{ rand(0,1) ? 'light' : 'dark' }}">
        <h1>{{ trans('brand.name') }}</h1>
        <p class="hidden-xs">{{ trans('brand.mission') }}</p>
        <div class="buttons hidden-xs">
            <a href="{{ url('designer/create') }}" class="btn btn-lg btn-default text-capitalize">
                {{ trans('design.create_designer') }}
            </a>
            <a href="{{ url('place/create') }}" class="btn btn-default hidden">
                {{ trans('place.create_place') }}
            </a>
        </div>
        <div class="icons hidden-xs">
            <a href="https://www.facebook.com/santakanidesign" target="_blank" title="Facebook">
                <span class="icon ion-social-facebook"></span>
            </a>
            <a href="https://twitter.com/santakanidesign" target="_blank" title="Twitter">
                <span class="icon ion-social-twitter"></span>
            </a>
            <a href="https://www.instagram.com/santakanidesign" target="_blank" title="Instagram">
                <span class="icon ion-social-instagram"></span>
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
                            @if ($designer->editor_pick)
                                <i class="editor-pick-icon fa fa-diamond" title="{{ trans('common.editor_pick') }}"></i>
                            @endif
                        </h3>

                        <p class="tagline text-muted">{{ $designer->text('tagline') }}</p>
                    </header>

                    <div class="image-gallery gallery">
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

            <div class="text-center">
                {!! $designers->appends(app('request')->all())->links() !!}
            </div>
        </div><!-- /.container -->
    </section>

@endsection
