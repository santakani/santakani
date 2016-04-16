@extends('layout.app', [
    'title' => $designer->getTranslation()->name . ' - Designer',
    'body_id' => 'designer-page',
    'body_class' => 'designer-page',
])

@section('content')

@if (!Auth::guest())
    <div id="action-bar">
        <div class="container">
            <a href="{{ url('/designer/'.$designer->id.'/edit') }}"
                id="edit-button" class="btn btn-default">Edit</a>
        </div>
    </div>
@endif

<header>
    <div class="container">
        <div class="main-image" style="background-image:url({{ url($designer->getMainImage()->getThumbUrl()) }});"></div>
        <div class="text">
            <h1 class="title">{{ $designer->getTranslation()->name }}</h1>
            <p>
                <a href="{{ $designer->getCity()->getUrl() }}">
                    {{ $designer->getCity()->getTranslation()->name }}</a>,
                <a href="{{ $designer->getCountry()->getUrl() }}">
                    {{ $designer->getCountry()->getTranslation()->name }}</a>
            </p>
            <ul class="tags">
                @foreach ($designer->getTags() as $tag)
                    <li><a href="{{ $tag->getUrl() }}">
                        #{{ $tag->getTranslation()->name }}
                    </a></li>
                @endforeach
            </ul>
        </div>
    </div>
</header>

<div id="picture-carousel" class="carousel">
    @foreach ($designer->getImages() as $image)
        <div class="picture-thumb" data-src="{{ url($image->getUrl()) }}"
            data-thumb="{{ url($image->getThumbUrl()) }}"
            style="background-image:url({{ url($image->getThumbUrl()) }})"></div>
    @endforeach
</div>

<article id="designer-{{ $designer->id }}" class="designer container">
    {{ $designer->getTranslation()->content }}
</article>

@endsection
