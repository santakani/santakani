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

@endsection
