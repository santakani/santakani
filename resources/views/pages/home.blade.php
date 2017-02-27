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
        </div>

        <form class="form-inline visible-xs" action="{{ url('search') }}" method="get">
            <input class="form-control input-lg" type="search" name="query" placeholder="&#xf4a4; {{ trans('common.search') }}" required>
        </form>

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

    <section id="featured-designers" class="featured-designers">
        <div class="container">
            <h2 class="text-center text-capitalize">{{ trans('home.featured_designers') }}</h2>
            <div class="row">
                @foreach ($designers as $designer)
                    <div class="col-sm-6 col-md-4 {{ $loop->index === 3 ? 'hidden-md hidden-lg' : '' }}">
                        @include('components.cards.designer-card', ['designer' => $designer])
                    </div>
                @endforeach
            </div><!-- /.row -->
        </div><!-- /.container -->
    </section>



    <section id="design-list" class="design-list">
        <div class="container">
            <h2 class="text-center text-capitalize">{{ trans('home.explore_designs') }}</h2>
            @include('components.tags.tag-filter')
            <div class="row">
                @foreach ($designs as $design)
                    <div class="col-sm-6 col-md-4">
                        @include('components.cards.design-card', ['design' => $design])
                    </div>
                @endforeach
            </div>

            <div class="text-center">
                {!! $designs->appends(app('request')->all())->links() !!}
            </div>
        </div><!-- /.container -->
    </section>

@endsection
