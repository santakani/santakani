@extends('layouts.app', [
    'title' => $designer->text('name') . ' - ' . trans('designer.designers'),
    'body_id' => 'designer-show-page',
    'body_classes' => ['designer-show-page', 'show-page', 'designer-page'],
    'active_nav' => 'designer',
    'og_title' => $designer->text('name'),
    'og_url' => $designer->url,
    'og_description' => $designer->excerpt('content'),
    'og_image' => empty($designer->image_id)?'':$designer->image->fileUrl('medium'),
    'twitter_card_type' => 'summary_large_image',
    'has_share_buttons' => true,
])

@section('header')
    <div class="page-cover"
        @if ($designer->image_id)
            style="background-image:url({{ $designer->image->large_file_url }})"
        @endif
        >

        <div class="raster raster-dark-dot"></div>

        <div class="buttons">
            @include('components.buttons.like', ['likeable' => $designer])
            @if (Auth::check())
                @if (Auth::user()->can('edit-designer', $designer))
                    @include('components.buttons.edit')
                @endif
                @if (Auth::user()->can('delete-designer', $designer))
                    @include('components.buttons.delete')
                @endif
            @endif
        </div><!-- /.buttons -->

        @if ($designer->logo_id)
            <img class="logo" src="{{ $designer->logo->small_file_url }}"/>
        @endif
        <h1 class="name">{{ $designer->text('name') }}</h1>
        <p class="tagline"><em>{{ $designer->excerpt('tagline', null, 140) }}</em></p>
        <p class="city">{{ $designer->city->full_name }}</p>
        <div class="links">
            @if (!empty($designer->facebook))
                <a href="{{ $designer->facebook }}" title="Facebook">
                    <i class="fa fa-facebook-official"></i>
                </a>
            @endif
            @if (!empty($designer->twitter))
                <a href="{{ $designer->twitter }}" title="Twitter">
                    <i class="fa fa-twitter"></i>
                </a>
            @endif
            @if (!empty($designer->google_plus))
                <a href="{{ $designer->google_plus }}" title="Google+">
                    <i class="fa fa-google-plus"></i>
                </a>
            @endif
            @if (!empty($designer->instagram))
                <a href="{{ $designer->instagram }}" title="Instagram">
                    <i class="fa fa-instagram"></i>
                </a>
            @endif
            @if (!empty($designer->email))
                <a href="mailto:{{ $designer->email }}" title="{{ trans('common.email') }}">
                    <i class="fa fa-envelope-o"></i>
                </a>
            @endif
            @if (!empty($designer->email))
                <a href="{{ $designer->website }}" title="{{ trans('common.website') }}">
                    <i class="fa fa-globe"></i>
                </a>
            @endif
        </div>

        @include('components.tag-list', ['tags' => $designer->tags])

    </div><!-- /.page-cover -->
@endsection

@section('main')
    <section id="designs">
        <div class="grid-container">
            <h1>
                {{ trans('designer.designs') }}
                @if (Auth::user()->can('edit-designer', $designer))
                    <form id="design-create-form" class="pull-right" action="{{ url('design')}}" method="post">
                        {!! csrf_field() !!}
                        <input type="hidden" name="designer_id" value="{{ $designer->id }}"/>
                        <button type="submit" id="design-create-button" class="btn btn-default"><i class="fa fa-plus"></i> {{ trans('common.create') }}</button>
                    </form>
                @endif
            </h1>
        </div>
        <div class="article-grid">
            @foreach ($designer->designs as $design)
                <article>
                    <a href="{{ $design->url }}">
                        <div class="cover">
                            @if ($design->image_id)
                                <img class="image" src="{{ $design->image->thumb_file_url }}"
                                    srcset="{{ $design->image->largethumb_file_url }} 2x"/>
                            @endif
                        </div>
                        <div class="text">
                            <div class="inner">
                                <h2>{{ $design->text('name') }}<br></h2>
                                <div class="excerpt">{{ $design->excerpt('content') }}</div>
                            </div>
                        </div>
                    </a>
                </article>
            @endforeach
        </div><!-- .list -->
    </section><!-- #design-list.article-list -->

    <section id="gallery">
        <div class="grid-container">
            <h1>{{ trans('common.gallery') }}</h1>
        </div>
        <div class="image-grid">
            @foreach ($designer->gallery_images as $image)
                    <a href="{{ $image->fileUrl('large') }}">
                        <img src="{{ $image->fileUrl('thumb') }}" />
                    </a>
            @endforeach
        </div>
    </section>

    <section id="about">
        <div class="grid-container">
            <h1>{{ trans('common.about') }}</h1>
            <div class="page-content">{!! $designer->html('content') !!}</div>
        </div>
    </section>
@endsection
