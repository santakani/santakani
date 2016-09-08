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
    <div id="gallery-wrap" class="gallery-wrap">
        <ul id="gallery" class="gallery">
            @forelse ($design->gallery_images as $image)
                <li data-thumb="{{ $image->fileUrl('largethumb') }}"
                    data-src="{{ $image->fileUrl('large') }}">
                    <img src="{{ $image->fileUrl('largethumb') }}" width="600" height="600"/>
                </li>
            @empty
                <li data-thumb="{{ url('img/placeholder/square.png') }}"
                    data-src="{{ url('img/placeholder/square.png') }}">
                    <img src="{{ url('img/placeholder/square.png') }}" width="600" height="600"/>
                </li>
            @endforelse
        </ul>
    </div><!-- /#gallery-wrap -->
    <div class="info">
        <h1 class="name">
            @if (Auth::check())
                <div class="pull-right">
                    @if (Auth::user()->can('edit-design', $design))
                        @include('components.buttons.edit')
                    @endif
                    @if (Auth::user()->can('delete-design', $design))
                        @include('components.buttons.delete')
                    @endif
                </div>
            @endif
            {{ $design->text('name') }}
        </h1>
        @if ($design->price && $design->currency)
            <h2 class="price">
                {{ $design->price }}
                <small title="{{ App\Localization\Currencies::name($design->currency) }}">{{ $design->currency }}</small>
            </h2>
            @if ($design->currency !== 'EUR')
                <p class="text-muted">~ {{ $design->eur_price }} <span title="{{ trans('currency.eur_name') }}">EUR</span></p>
            @endif
        @endif

        <p class="buttons">
            <a class="btn btn-lg btn-default {{ empty($design->webshop)?'disabled':'' }}" href="{{ $design->webshop }}" target="_blank"><i class="fa fa-lg fa-shopping-basket"></i> {{ trans('common.buy') }}</a>
            @include('components.buttons.like', ['class' => 'btn-lg','likeable' => $design])
        </p><!-- /.buttons -->

        <p>{{ trans('common.tags') }}</p>
        <p>@include('components.tag-list', ['tags' => $design->tags])</p>

        <p>{{ trans('designer.designer') }}</p>
        <p>
            <a href="{{ $design->designer->url }}">
                {{ $design->designer->text('name') }} ({{ $design->designer->city->full_name }})
            </a>
        </p>
    </div><!-- /.info -->
@endsection

@section('main')
    <div id="content" class="page-content">
        {!! $design->html('content') !!}
    </div><!-- /#content.page-content -->
    <div id="sidebar" class="sidebar">
        <h3>{{ trans('designer.designer') }}</h3>
        <p>
            <img class="img-responsive" src="{{ $design->designer->image->fileUrl('largethumb') }}" width="600" height="600"/>
        </p>
        <p><strong><a href="{{ $design->designer->url }}">{{ $design->designer->text('name') }}</a></strong></p>
        <p><em>{{ $design->designer->city->full_name }}</em></p>
        <blockquote>{{ $design->designer->text('tagline') }}</blockquote>
        <p>{{ $design->designer->excerpt('content') }} <a href="{{ $design->designer->url }}">{{ strtolower(trans('common.more')) }}</a></p>
    </div>
@endsection
