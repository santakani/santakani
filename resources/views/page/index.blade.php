@extends('layout.app', [
    'body_id' => 'home-page',
    'body_class' => 'home-page index-page',
    'active_nav' => 'home',
])

@section('header')
<div id="home-carousel" class="carousel">
    <div class="carousel-cell" style="background-image:url(/storage/images/0/1/large.jpg)">
        <div class="jumbotron">
            <div class="container">
                <h1>Designers + Design Lovers</h1>
                <p>This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
                <p>
                    <a class="btn btn-info btn-lg" href="/designer" role="button">Explore designer list</a>
                    <a class="btn btn-success btn-lg" href="/designer/create" role="button">Create designer profile</a>
                </p>
            </div><!-- .container -->
        </div><!-- .jumbotron -->
    </div><!-- .carousel-cell -->
    <div class="carousel-cell" style="background-image:url(/storage/images/0/2/large.jpg)">
        <div class="jumbotron">
            <div class="container">
                <h1>Design Shops, Design Museums, and More</h1>
                <p>This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
                <p>
                    <a class="btn btn-info btn-lg" href="/place" role="button">Open design map</a>
                    <a class="btn btn-success btn-lg" href="/place/create" role="button">Mark a design shop</a>
                </p>
            </div><!-- .container -->
        </div><!-- .jumbotron -->
    </div><!-- .carousel-cell -->
    <div class="carousel-cell" style="background-image:url(/storage/images/0/3/large.jpg)">
        <div class="jumbotron">
            <div class="container">
                <h1>The Story of Endless Creativity</h1>
                <p>This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
                <p>
                    <a class="btn btn-info btn-lg" href="/story" role="button">Start reading</a>
                    <a class="btn btn-success btn-lg" href="/story/create" role="button">Write &amp; publish</a>
                </p>
            </div><!-- .container -->
        </div><!-- .jumbotron -->
    </div><!-- .carousel-cell -->
</div>
@endsection

@section('main')
<section id="story-section">
    <div class="container">
        <h2>
            Stories
            <a class="btn btn-default pull-right" href="/story" role="button">
                More <i class="fa fa-angle-double-right"></i>
            </a>
        </h2>
        <div id="home-story-list" class="story-list row">
            @foreach ($stories as $i => $story)
                <div class="col-sm-4 col-lg-3 {{ $i > 3 ? 'hidden-lg hidden-xs' : '' }}">
                    <article id="story-{{ $story->id }}" class="story material-card" data-id="{{ $story->id }}">
                        <a href="{{ $story->url }}">
                            @if ($image = $story->image)
                                <img class="cover-image" src="{{ $image->file_urls['thumb'] }}" />
                            @else
                                <img class="cover-image" src="http://placehold.it/300x300?text=NO+IMAGE" />
                            @endif
                            <div class="shadow"></div>
                            <div class="text">
                                <h1>{{ $story->title }}</h1>
                                {{ $story->excerpt }}
                            </div>
                        </a>
                    </article>
                </div>
            @endforeach
        </div><!-- #home-story-list.row -->
    </div><!-- .container -->
</section><!-- #story-section -->

<section id="designer-section">
    <div class="container">
        <h2>
            Designers
            <a class="btn btn-default pull-right" href="/designer" role="button">
                More <i class="fa fa-angle-double-right"></i>
            </a>
        </h2>
        <div id="home-designer-list" class="designer-list row">
            @foreach ($designers as $i => $designer)
                <div class="col-md-6">
                    <article id="designer-{{ $designer->id }}" class="designer material-card"
                        data-id="{{ $designer->id }}">
                        <a href="{{ $designer->url }}">
                            <div class="cover-image" style="background-image:url({{ $designer->image_id ? $designer->image->file_urls['medium'] : '' }})">
                                <img class="logo-image" src="{{ $designer->logo_id ? $designer->logo->file_urls['thumb'] : '' }}" />
                            </div>
                            <div class="text">
                                <h1>{{ $designer->text('name') }}<br>
                                    <small>{{ $designer->text('tagline') }}</small></h1>
                                <div class="excerpt">{{ $designer->excerpt('content') }}</div>
                            </div>
                        </a>
                    </article>
                </div>
            @endforeach
        </div><!-- #home-designer-list -->
    </div><!-- .container -->
</section><!-- #designer-section -->

<section id="place-section">
    <div class="container">
        <h2>
            Places
            <a class="btn btn-default pull-right" href="/place" role="button">
                More <i class="fa fa-angle-double-right"></i>
            </a>
        </h2>
        <div id="home-place-list" class="place-list row">
            @foreach ($places as $i => $place)
                <div class="col-md-6">
                    <article id="place-{{ $place->id }}" class="place material-card">
                        <a href="{{ $place->url }}">
                            <div class="cover-image" style="background-image:url({{ $place->image?$place->image->file_urls['medium']:'' }})">
                                <span class="type">{{ $place->type }}</span>
                            </div>
                            <div class="text">
                                <h1 class="name">
                                    {{ $place->text('name') }}
                                    <small>
                                        {{ $place->city->full_name }}
                                    </small>
                                </h1>
                                <div class="excerpt">
                                    {{ $place->excerpt('content') }}
                                </div>
                            </div>
                        </a>
                    </article>
                </div>
            @endforeach
        </div><!-- #home-place-list -->
    </div><!-- .container -->
</section><!-- #place-section -->

<section id="tag-section">
    <div class="container">
        <h2>
            Tags
            <a class="btn btn-default pull-right" href="/tag" role="button">
                More <i class="fa fa-angle-double-right"></i>
            </a>
        </h2>
        <div id="home-tag-list" class="tag-list row">
            @foreach ($tags as $tag)
                <div class="col-xs-6 col-sm-4 col-md-3">
                    <article id="tag-{{ $tag->id }}" class="tag" data-id="{{ $tag->id }}">
                        <a href="/tag/{{ $tag->id }}">
                            @if ($tag->image_id)
                                <img class="cover-image" src="{{ $tag->image->getFileUrl('thumb') }}" width="300" height="300" />
                            @else
                                <img class="cover-image" src="/img/placeholder/blank/300x300.svg" width="300" height="300" />
                            @endif
                            <div class="text">
                                <h3>{{ $tag->text('name') }}</h3>
                            </div>
                        </a>
                    </article>
                </div>
            @endforeach
        </div><!-- #home-tag-list -->
    </div><!-- .container -->
</section><!-- #tag-section -->
@endsection
