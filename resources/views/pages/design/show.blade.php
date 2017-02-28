@extends('layouts.app', [
    'title' => $design->text('name') . ' - ' . trans('design.designs'),
    'body_id' => 'design-show-page',
    'body_classes' => ['design-show-page', 'show-page', 'design-page'],
    'active_nav' => 'design',
    'og_title' => $design->text('name'),
    'og_url' => $design->url,
    'og_description' => $design->excerpt('content'),
    'og_image' => empty($design->image_id)?'':$design->image->fileUrl('medium'),
    'twitter_card_type' => 'summary_large_image',
])

@section('main')

<header>
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <ul id="gallery" class="gallery">
                    @forelse ($design->gallery_images as $image)
                        <li data-thumb="{{ $image->fileUrl('largethumb') }}"
                            data-src="{{ $image->fileUrl('large') }}">
                            <img src="{{ $image->fileUrl('largethumb') }}" width="600" height="600"/>
                        </li>
                    @empty
                        <li data-thumb="{{ url('img/placeholder/thumb.svg') }}"
                            data-src="{{ url('img/placeholder/largethumb.svg') }}">
                            <img src="{{ url('img/placeholder/square.svg') }}" width="600" height="600"/>
                        </li>
                    @endforelse
                </ul>
            </div><!-- /.col-* -->

            <div class="info col-sm-6">
                <h1 class="name">
                    {{ $design->text('name') }}
                </h1>
                @if ($design->price && $design->currency)
                    <div class="price lead text-success">
                        {{ $design->price }}
                        {{ $design->currency }}
                    </div>
                    @if ($design->currency !== 'EUR')
                        <p class="text-muted">~ {{ $design->eur_price }} <span title="{{ trans('currency.eur_name') }}">EUR</span></p>
                    @endif
                @endif

                <ul class="metadata list-inline text-muted">
                    @if ($design->designer_id)
                        <li>
                            <a href="{{ $design->designer->url }}">
                                {{ $design->designer->text('name') }}
                            </a>
                        </li>
                        @if ($design->designer->city_id)
                            <li>{{ $design->designer->city->text('name') }}</li>
                        @endif
                    @endif
                    <li>{{ trans_choice('common.like_count', $design->like_count) }}</li>
                </ul>

                @include('pages.design.show-action-bar')

                @include('components.tags.tags-hash', ['tags' => $design->tags, 'class' => 'text-muted'])
            </div><!-- /.col-* -->
        </div><!-- /.row -->
    </div><!-- /.container -->
</header>


<div class="container">
    <div id="page-content" class="page-content ">
        {!! $design->html('content') !!}
    </div><!-- /#page-content -->

    @if ($design->designer_id)
        <h2>{{ trans('designer.designer') }}</h2>
        <div class="row">
            <div class="col-sm-6 col-md-4">
                @include('components.cards.designer-card', ['designer' => $design->designer])
            </div><!-- /.col-* -->
        </div><!-- /.row -->

        <h2>{{ trans('design.more_designs_by_designer') }}</h2>
        <div class="row">
            @foreach($design->designer->designs()->where('id', '!=', $design->id)->take(4)->get() as $d)
                <div class="col-sm-6 col-md-4 {{ $loop->index === 2 ? 'hidden-sm' : '' }}">
                    @include('components.cards.design-card', ['design' => $d])
                </div><!-- /.col-* -->
            @endforeach
        </div><!-- /.row -->
    @endif

</div><!-- /.container -->

@endsection

@if (Auth::check() && Auth::user()->can('edit-design', $design))
    @push('modals')
        @include('components.modals.transfer-modal', ['user' => $design->user])
    @endpush
@endif
