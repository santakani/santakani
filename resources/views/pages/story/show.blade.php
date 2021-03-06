@extends('layouts.app', [
    'title' => $story->text('title') . ' - ' . trans('story.story'),
    'body_id' => 'story-show-page',
    'body_classes' => ['story-show-page', 'story-page', 'show-page'],
    'active_nav' => 'story',
    'og_title' => $story->text('title'),
    'og_url' => $story->url,
    'og_description' => $story->excerpt('content'),
    'og_image' => empty($story->image_id)?'':$story->image->fileUrl('medium'),
    'twitter_card_type' => 'summary_large_image',
])

@section('main')
    <div class="container-content">
        @if (empty($story->published_at))
            <div class="alert alert-warning">{{ trans('story.draft_notice') }} <a href="{{ $story->url . '/edit' }}">{{ trans('common.edit') }}</a></div>
        @endif

        @if ($story->image_id)
            <img class="img-responsive" src="{{ $story->image->banner_file_url }}" srcset="{{ $story->image->largebanner_file_url }} x2">
        @endif

        <h1 class="page-header">{{ $story->text('title') }}</h1>

        <ul class="info list-inline text-muted">
            @if (!empty($story->published_at))
                <li>{{ $story->published_at->formatLocalized(App\Localization\Languages::dateFormat()) }}</li>
            @endif
            <li>{{ trans_choice('common.like_count', $story->like_count) }}</li>
        </ul>

        <div class="row text-center">
            <div class="col-xs-3">
                @include('components.buttons.like', ['likeable' => $story])
            </div>
            <div class="col-xs-3">
                <div class="dropdown">
                    <button type="button" class="btn-icon dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="{{ trans('common.share') }}">
                        <span class="icon ion-ios-upload-outline"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li><a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($story->url) }}" target="_blank">Facebook</a></li>
                        <li><a href="https://plus.google.com/share?url={{ urlencode($story->url) }}" target="_blank">Google+</a></li>
                        <li><a href="https://twitter.com/intent/tweet?hashtags=santakanidesign&amp;url={{ urlencode($story->url) }}" target="_blank">Twitter</a></li>
                        <li><a href="http://www.tumblr.com/share/link?url={{ urlencode($story->url) }}" target="_blank">Tumblr</a></li>

                        <li><a href="#">
                            微信
                            <img class="qrcode img-responsive" src="" data-url="{{ $story->url }}" width="300" height="300">
                        </a></li>

                    </ul>
                </div>
            </div>
            <div class="col-xs-3">
                @if (Auth::check() && Auth::user()->can('edit-story', $story))
                    <a id="edit-button" class="btn-icon" href="{{ url()->current() . '/edit' }}" title=" {{ trans('common.edit') }}">
                        <span class="icon ion-ios-compose-outline"></span>
                    </a>
                @endif
            </div>
            <div class="col-xs-3">
                <div class="dropdown">
                    <button type="button" class="btn-icon dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="{{ trans('common.more') }}">
                        <span class="icon ion-ios-more-outline"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right">
                        @if (Auth::check() && Auth::user()->can('editor-rating'))
                            <li>
                                <a id="editor-rating-button" class="editor-rating-button" href="#" data-url="{{ $story->url }}" data-rating="{{ $story->editor_rating }}">
                                    {{ trans('common.editor_rating') }}
                                </a>
                            </li>
                        @endif
                        @if (Auth::check() && Auth::user()->can('delete-story', $story))
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
                            <a href="mailto:contact@santakani.com?subject=[Santakani] Report Problems&amp;body=Please describe problems on page {{ $story->url }}">
                                {{ trans('common.report') }}
                            </a>
                        </li>
                    </ul>
                </div><!-- /.dropdown -->
            </div>
        </div><!-- /.row -->

        <div id="page-content" class="page-content">{!! $story->html('content') !!}</div>

        @include('components.tags.tags-hash', ['tags' => $story->tags])

        @if ($story->user_id)
            <div class="author">
                <h3>{{ trans('common.author') }}</h3>
                @include('components.cards.user-card', ['user' => $story->user])
            </div>
        @endif
    </div>
@endsection
