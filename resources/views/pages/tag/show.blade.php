@extends('layouts.app', [
    'title' => $tag->text('name') . ' - ' . trans('common.tag'),
    'body_id' => 'tag-show-page',
    'body_classes' => ['tag-show-page', 'tag-page', 'show-page'],
    'og_title' => $tag->text('name'),
    'og_url' => $tag->url,
    'og_description' => $tag->excerpt('description'),
    'og_image' => empty($tag->image_id)?'':$tag->image->fileUrl('medium'),
])

@section('header')
<div class="container">
    <p><a href="/tag"><i class="fa fa-angle-double-left"></i> {{ trans('common.tags') }}</a></p>

    <div class="row">
        <div class="col-sm-4 col-md-4 col-lg-3">
            <img class="cover-image" src="{{ $tag->image_id?$tag->image->fileUrl('thumb'):'/img/placeholder/blank/300x300.svg' }}">
        </div><!-- .col -->
        <div class="col-sm-8 col-md-8 col-lg-9">
            <h1>{{ $tag->text('name') }}</h1>
            <div class="action-buttons">
                @include('components.buttons.like', ['likeable' => $tag])
                @if (Auth::check())
                    @if (Auth::user()->can('edit-tag'))
                        @include('components.buttons.edit')
                    @endif
                    @if (Auth::user()->can('delete-tag'))
                        @include('components.buttons.delete')
                    @endif
                @endif
            </div>
            <br>
            <p>{{ $tag->text('description') }}</p>
        </div><!-- .col -->
    </div><!-- .row -->
</div><!-- .container -->
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
                                <img class="cover-image" src="{{ $image->fileUrl('thumb') }}" />
                            @else
                                <img class="cover-image" src="http://placehold.it/300x300?text=NO+IMAGE" />
                            @endif
                            <div class="shadow"></div>
                            <div class="text">
                                <h1>{{ $story->title }}</h1>
                                {{ $story->excerpt('content') }}
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
                            <div class="cover-image" style="background-image:url({{ $designer->image_id ? $designer->image->fileUrl('medium') : '' }})">
                                <img class="logo-image" src="{{ $designer->logo_id ? $designer->logo->fileUrl('thumb') : '' }}" />
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
                            <div class="cover-image" style="background-image:url({{ $place->image?$place->image->fileUrl('medium'):'' }})">
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

@endsection
