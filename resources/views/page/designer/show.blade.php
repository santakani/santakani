@extends('layout.app', [
    'title' => $designer->name . ' - Designer',
    'body_id' => 'designer-show-page',
    'body_class' => 'designer-show show',
])

@section('header')
<header style="background-image:url({{ $designer->image->large_url }});">
    <div class="action-bar target">
        @if ($can_edit)
            <a href="{{ url('designer/'.$designer->id.'/edit') }}"
                id="edit-button" class="btn btn-default btn-sm">Edit</a>
        @endif
        @if ($can_translate)
            <a href="{{ url('designer/'.$designer->id.'/translate') }}"
                id="edit-button" class="btn btn-default btn-sm">Translate</a>
        @endif
    </div><!-- .action-bar -->

    <div class="text">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-4 target">
                    <p class="tagline">{{ $designer->tagline }}</p>
                    <h1>{{ $designer->name }}</h1>
                    <p class="location">
                        <a href="{{ url('city/'.$designer->city_id) }}">
                            {{ $designer->city_name or 'Unknown' }}</a>,
                        <a href="{{ url('country/'.$designer->country_id) }}">
                            {{ $designer->country_name or 'Unknown' }}</a>
                    </p>
                    <p class="links">
                        @if (!empty($designer->facebook))
                            <a href="{{ $designer->facebook }}">
                                <i class="fa fa-facebook"></i>
                            </a>
                        @endif
                        @if (!empty($designer->twitter))
                            <a href="{{ $designer->twitter }}">
                                <i class="fa fa-twitter"></i>
                            </a>
                        @endif
                        @if (!empty($designer->google_plus))
                            <a href="{{ $designer->google_plus }}">
                                <i class="fa fa-google-plus"></i>
                            </a>
                        @endif
                        @if (!empty($designer->instagram))
                            <a href="{{ $designer->instagram }}">
                                <i class="fa fa-instagram"></i>
                            </a>
                        @endif
                        @if (!empty($designer->email))
                            <a href="mailto:{{ $designer->email }}">
                                <i class="fa fa-envelope"></i>
                            </a>
                        @endif
                    </p>
                </div><!-- .col-* -->
                <div class="col-md-6"></div><!-- .col-* -->
            </div><!-- .row -->
        </div><!--.container-->
    </div><!--.text-->
</header>
@endsection

@section('main')

<div id="picture-carousel" class="carousel">
    @foreach ($designer->images as $image)
        <div class="picture-thumb" data-src="{{ url($image->getUrl()) }}"
            data-thumb="{{ url($image->getThumbUrl()) }}"
            style="background-image:url({{ url($image->getThumbUrl()) }})"></div>
    @endforeach
</div>

<div class="container">
    {!! $designer->content !!}
    <p class="tags target">
        @foreach ($designer->tags as $tag)
            <a href="{{ $tag->getUrl() }}">
                #{{ $tag->getTranslation()->name }}
            </a>
        @endforeach
    </p>
</div>
@endsection
