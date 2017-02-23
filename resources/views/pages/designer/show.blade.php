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
])

@section('main')
    <header id="designer-header">
        <div class="container">

            <div class="cover-wrap">
                @if ($designer->image_id)
                    <img class="cover" src="{{ $designer->image->largebanner_file_url }}" width="1200" height="600">
                @else
                    <img class="cover" src="{{ url('img/placeholder/largebanner.svg') }}" width="1200" height="600">
                @endif

                <div class="brand clearfix">
                    @if ($designer->logo_id)
                        <img class="logo" src="{{ $designer->logo->thumb_file_url }}" width="300" height="300" alt="Logo" title="Logo">
                    @else
                        <img class="logo" src="{{ url('img/placeholder/thumb.svg') }}" width="300" height="300" alt="Logo" title="Logo">
                    @endif
                    <div class="text">
                        <h1 class="name text-nowrap">{{ $designer->text('name') }}</h1>
                        <div class="tagline">{{ $designer->text('tagline') }}</div>
                    </div>
                </div><!-- /.clearfix -->
            </div>

            <div class="data-action">
                <ul class="metadata list-inline text-muted">
                    @if ($designer->city_id)
                        <li>{{ $designer->city->full_name }}</li>
                    @endif
                    <li>{{ trans_choice('design.design_count', $designer->designs->count()) }}</li>
                    <li>{{ trans_choice('common.like_count', $designer->like_count) }}</li>
                </ul>
                <div class="action-bar">
                    <div class="action">
                        @include('components.buttons.like', ['likeable' => $designer])
                    </div>
                    <div class="action">
                        <div class="dropdown">
                            <button type="button" class="btn-icon dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="{{ trans('common.share') }}">
                                <span class="icon ion-ios-upload-outline"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($designer->url) }}" target="_blank">Facebook</a></li>
                                <li><a href="https://plus.google.com/share?url={{ urlencode($designer->url) }}" target="_blank">Google+</a></li>
                                <li><a href="https://twitter.com/intent/tweet?hashtags=santakanidesign&amp;url={{ urlencode($designer->url) }}" target="_blank">Twitter</a></li>
                                <li><a href="http://www.tumblr.com/share/link?url={{ urlencode($designer->url) }}" target="_blank">Tumblr</a></li>

                                <li><a href="#">
                                    微信
                                    <img class="qrcode img-responsive" src="" data-url="{{ $designer->url }}" width="300" height="300">
                                </a></li>

                            </ul>
                        </div>
                    </div>
                    @if (Auth::check() && Auth::user()->can('edit-designer', $designer))
                        <div class="action">
                            <a id="edit-button" class="btn-icon" href="{{ url()->current() . '/edit' }}" title=" {{ trans('common.edit') }}">
                                <span class="icon ion-ios-compose-outline"></span>
                            </a>
                        </div>
                    @endif
                    <div class="action">
                        <div class="dropdown">
                            <button type="button" class="btn-icon dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="{{ trans('common.more') }}">
                                <span class="icon ion-ios-more-outline"></span>
                            </button>

                            <ul class="dropdown-menu dropdown-menu-right">
                                @if (Auth::check() && Auth::user()->can('editor-pick'))
                                    <li>
                                        <a id="editor-pick-button" class="{{ $designer->editor_pick?'picked':'' }}" href="#">
                                            {{ trans('common.editor_pick') }}
                                            @if ($designer->editor_pick)
                                                <span class="text-success">&#x2713;</span>
                                            @endif
                                        </a>
                                    </li>
                                @endif

                                @if (Auth::check() && Auth::user()->can('transfer-designer', $designer))
                                    <li>
                                        <a id="transfer-button" href="#" data-toggle="modal" data-target="#transfer-modal">
                                            {{ trans('common.transfer') }}
                                        </a>
                                    </li>
                                @endif

                                @if (Auth::check() && Auth::user()->can('delete-designer', $designer))
                                    <li>
                                        <a id="delete-button" href="#">
                                            {{ trans('common.delete') }}
                                        </a>
                                    </li>
                                    @if (Auth::user()->role === 'admin' || Auth::user()->role === 'editor')
                                        <li>
                                            <a id="force-delete-button" href="#">
                                                {{ trans('common.delete_permanently') }}
                                            </a>
                                        </li>
                                    @endif
                                @endif
                                <li>
                                    <a href="mailto:contact@santakani.com?subject=[Santakani] Report Problems&amp;body=Please describe problems on page {{ $designer->url }}">
                                        {{ trans('common.report') }}
                                    </a>
                                </li>
                            </ul>
                        </div><!-- /.dropdown -->
                    </div>
                </div><!-- /.action-bar -->

            </div><!-- /.data-action -->

        </div><!-- /.container -->
    </header>

    <div class="container">
        <ul id="tabs" class="nav nav-tabs">
            <li class="{{ $tab === 'overview' ? 'active' : '' }}">
                <a href="{{ $designer->url }}">{{ trans('common.overview') }}</a>
            </li>
            <li class="{{ $tab === 'description' ? 'active' : '' }}">
                <a href="{{ $designer->url }}?tab=description">
                    {{ trans('common.description') }}
                </a>
            </li>
            <li class="{{ $tab === 'designs' ? 'active' : '' }}">
                <a href="{{ $designer->url }}?tab=designs">
                    {{ trans('design.designs') }}
                    <span class="badge hidden-xs">{{ $designer->designs()->count() }}</span>
                </a>
            </li>
            <li class="{{ $tab === 'images' ? 'active' : '' }}">
                <a href="{{ $designer->url }}?tab=images">
                    {{ trans('common.images') }}
                    <span class="badge hidden-xs">{{ $designer->images()->where('weight', '>', 0)->count() }}</span>
                </a>
            </li>
            <li class="{{ $tab === 'likes' ? 'active' : '' }}">
                <a href="{{ $designer->url }}?tab=likes">
                    {{ trans_choice('common.like_noun', 10) }}
                    <span class="badge hidden-xs">{{ $designer->likes()->count() }}</span>
                </a>
            </li>
        </ul>

        @include('pages.designer.show-' . $tab)
    </div>

@endsection

@if (Auth::check() && Auth::user()->can('edit-designer', $designer))
    @push('modals')
        @include('components.modals.transfer-modal', ['user' => $designer->user])
    @endpush
@endif
