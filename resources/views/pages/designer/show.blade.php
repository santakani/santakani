@extends('layouts.app', [
    'title' => $designer->text('name') . ' - ' . trans('designer.designers'),
    'body_id' => 'designer-show-page',
    'body_classes' => ['designer-show-page', 'show-page', 'designer-page'],
    'active_nav' => 'designer',
    'og_title' => $designer->text('name'),
    'og_url' => $designer->url,
    'og_description' => $designer->excerpt('content'),
    'og_image' => empty($designer->image_id)?'':$designer->image->fileUrl('medium'),
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
    <div class="container">
        <!-- Nav tabs -->
        <ul id="main-tabs" class="nav nav-justified nav-strokes" role="tablist">
            <li class="active"><a href="#gallery" data-toggle="tab">
                {{ trans('common.gallery') }}
            </a></li>
            <li><a href="#biography" data-toggle="tab">
                {{ trans('common.about') }}
            </a></li>
            <li><a href="#followers" data-toggle="tab">
                {{ trans('common.followers') }}
            </a></li>
        </ul>

        <br>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="gallery">
                <div class="gallery gallery-grid">
                    @foreach ($designer->gallery_images as $image)
                            <a href="{{ $image->fileUrl('large') }}">
                                <img src="{{ $image->fileUrl('thumb') }}" />
                            </a>
                    @endforeach
                </div>
            </div>

            <div role="tabpanel" class="tab-pane" id="biography">
                {!! $designer->html('content') !!}
            </div>

            <div role="tabpanel" class="tab-pane" id="followers">
                <div class="row">
                    @foreach ($designer->likes as $like)
                        <div class="col-sm-6 col-lg-4">
                            <article class="user material-card">
                                <img class="avatar" src="{{ $like->user->avatar(150) }}"/>
                                <div class="text">
                                    <div class="name">{{ $like->user->name }}</div>
                                    <div class="description text-muted">{{ $like->user->description }}</div>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div><!-- /.container -->
@endsection
