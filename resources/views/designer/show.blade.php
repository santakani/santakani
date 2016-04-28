@extends('layout.app', [
    'title' => $designer->name . ' - Designer',
    'body_id' => 'designer-page',
    'body_class' => 'designer-page',
])

@section('content')

@if ($can_edit || $can_translate)
    <div id="action-bar">
        <div class="container">
            @if ($can_edit)
                <a href="{{ url('designer/'.$designer->id.'/edit') }}"
                    id="edit-button" class="btn btn-default">Edit</a>
            @endif
            @if ($can_translate)
                <a href="{{ url('designer/'.$designer->id.'/translate') }}"
                    id="edit-button" class="btn btn-default">Translate</a>
            @endif
        </div>
    </div>
@endif

<header>
    <div class="container">
        @if ($img = $designer->image)
            <div class="main-image" style="background-image:url({{ $img->getThumbUrl() }});"></div>
        @endif
        <div class="text">
            <h1 class="title">{{ $designer->name }}</h1>
            <p>
                <a href="{{ url('city/'.$designer->city_id) }}">
                    {{ $designer->city_name or 'Unknown' }}</a>,
                <a href="{{ url('country/'.$designer->country_id) }}">
                    {{ $designer->country_name or 'Unknown' }}</a>
            </p>
            <ul class="tags">
                @foreach ($designer->tags as $tag)
                    <li><a href="{{ $tag->getUrl() }}">
                        #{{ $tag->getTranslation()->name }}
                    </a></li>
                @endforeach
            </ul>
        </div>
    </div>
</header>

<div id="picture-carousel" class="carousel">
    @foreach ($designer->images as $image)
        <div class="picture-thumb" data-src="{{ url($image->getUrl()) }}"
            data-thumb="{{ url($image->getThumbUrl()) }}"
            style="background-image:url({{ url($image->getThumbUrl()) }})"></div>
    @endforeach
</div>

<article id="designer-{{ $designer->id }}" class="designer container">
    {{ $designer->content }}
</article>

@endsection
