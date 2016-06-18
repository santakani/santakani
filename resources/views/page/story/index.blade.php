@extends('layout.app', [
    'title' => 'Design Stories',
    'body_id' => 'story-index-page',
    'body_class' => 'story-index-page index-page story-page',
    'active_nav' => 'story',
])

@section('main')
<div class="container">
    <div id="story-list" class="story-list row">
        @foreach ($stories as $story)
            <div class="col-sm-4 col-lg-3">
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
    </div><!-- #story-list -->
    <div class="text-center">
        {!! $stories->links() !!}
    </div>
</div><!-- .container -->
@endsection
