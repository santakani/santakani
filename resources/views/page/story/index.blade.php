@extends('layout.app', [
    'title' => 'Design Stories',
    'body_id' => 'story-index-page',
    'body_class' => 'story-index-page index-page story-page',
    'active_nav' => 'story',
])

@section('main')
<div class="container">
    <div class="row">
        @foreach ($stories as $story)
            <article id="story-{{ $story->id }}" class="story col-xs-12 col-sm-6 col-md-4 col-lg-3"
                data-id="{{ $story->id }}">
                <a href="{{ $story->url }}">
                    @if ($image = $story->image)
                        <img class="featured-image" src="{{ $image->file_urls['thumb'] }}" />
                    @else
                        <img class="featured-image" src="http://placehold.it/300x300?text=NO+IMAGE" />
                    @endif
                    <div class="shadow"></div>
                    <div class="text">
                        {{ $story->text('name') }}: {{ $story->text('tagline') }}
                    </div>
                </a>
            </article>
        @endforeach
    </div><!-- .row -->
    {!! $stories->links() !!}
</div><!-- .container -->
@endsection
