@extends('layout.app', [
    'title' => 'Design Stories',
    'body_id' => 'story-index-page',
    'body_class' => 'story-index-page index-page story-page',
    'active_nav' => 'story',
])

@section('main')
<div class="custom-container">
    <div class="clearfix">
    @foreach ($stories as $story)
        <article id="story-{{ $story->id }}" class="story" data-id="{{ $story->id }}">
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
    @endforeach
    </div>
    <div class="text-center">
        {!! $stories->links() !!}
    </div>
</div><!-- .container -->
@endsection
