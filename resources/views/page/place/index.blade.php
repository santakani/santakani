@extends('layout.app', [
    'title' => 'Places',
    'body_id' => 'place-index-page',
    'body_class' => 'place-index-page place-page index-page',
    'active_nav' => 'place',
])

@section('main')
<div id="place-map">
    <div id="place-map-inner">
        <div id="place-map-draw"></div>
    </div>
</div>

<div id="place-list">
    <div class="container-fluid">
        @foreach ($places as $place)
            <article id="place-{{ $place->id }}" class="place material-card"
                data-id="{{ $place->id }}" data-latitude="{{ $place->latitude }}"
                data-longitude="{{ $place->longitude }}">
                <a href="{{ $place->url }}">
                    <div class="cover-image" style="background-image:url({{ $place->image?$place->image->file_urls['medium']:'' }})">
                        <span class="type">{{ $place->type }}</span>
                    </div>
                    <div class="text">
                        <h1 class="name">
                            <span class="dot"></span>
                            {{ $place->text('name') }}
                            <small>
                                {{ $place->address }}
                            </small>
                        </h1>
                        <div class="excerpt">
                            {{ $place->excerpt('content') }}
                        </div>
                    </div>
                </a>
            </article>
        @endforeach
    </div>
    <div class="text-center">
        {!! $places->links() !!}
    </div>
</div><!-- #place-list -->
@endsection
