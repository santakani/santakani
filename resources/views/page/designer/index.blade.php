@extends('layout.app', [
    'title' => 'Design Stories',
    'body_id' => 'designer-index-page',
    'body_class' => 'designer-index index',
])

@section('main')
<div class="container">
    <div class="row">
        @foreach ($designers as $designer)
            <article id="story-{{ $designer->id }}" class="story grid-item col-xs-12 col-sm-6 col-md-4 col-lg-3"
                data-id="{{ $designer->id }}">
                <a href="{{ $designer->url }}">
                    @if ($image = $designer->image)
                        <img class="featured-image" src="{{ $image->file_urls['thumb'] }}" />
                    @else
                        <img class="featured-image" src="http://placehold.it/300x300?text=NO+IMAGE" />
                    @endif
                    <div class="shadow"></div>
                    <div class="text">
                        {{ $designer->text('name') }}: {{ $designer->text('tagline') }}
                    </div>
                </a>
            </article>
        @endforeach
    </div><!-- .row -->
</div><!-- .container -->
@endsection
