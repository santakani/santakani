@extends('layouts.app', [
    'title' => $design->text('name') . ' - ' . trans('designer.designs'),
    'body_id' => 'design-show-page',
    'body_classes' => ['design-show-page', 'show-page', 'design-page'],
    'active_nav' => 'design',
    'og_title' => $design->text('name'),
    'og_url' => $design->url,
    'og_description' => $design->excerpt('content'),
    'og_image' => empty($design->image_id)?'':$design->image->fileUrl('medium'),
    'twitter_card_type' => 'summary_large_image',
    'has_share_buttons' => true,
])

@section('header')
    <div class="page-cover"
        @if ($design->image_id)
            style="background-image:url({{ $design->image->large_file_url }})"
        @endif
        >

        <div class="raster raster-dark-dot"></div>

        <div class="buttons">
            @include('components.buttons.like', ['likeable' => $design])
            @if (Auth::check())
                @if (Auth::user()->can('edit-design', $design))
                    @include('components.buttons.edit')
                @endif
                @if (Auth::user()->can('delete-design', $design))
                    @include('components.buttons.delete')
                @endif
            @endif
        </div><!-- /.buttons -->

        @if ($design->logo_id)
            <img class="logo" src="{{ $design->logo->small_file_url }}"/>
        @endif
        <h1 class="name">{{ $design->text('name') }}</h1>
        @include('components.tag-list', ['tags' => $design->tags])

    </div><!-- /.page-cover -->
@endsection

@section('main')
    <div class="container">
        <div role="tabpanel" class="tab-pane active" id="gallery">
            <div class="gallery gallery-grid">
                @foreach ($design->gallery_images as $image)
                        <a href="{{ $image->fileUrl('large') }}">
                            <img src="{{ $image->fileUrl('thumb') }}" />
                        </a>
                @endforeach
            </div>
        </div>

        <div role="tabpanel" class="tab-pane" id="biography">
            {!! $design->html('content') !!}
        </div>

        <div role="tabpanel" class="tab-pane" id="followers">
            <div class="row">
                @foreach ($design->likes as $like)
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
    </div><!-- /.container -->
@endsection
