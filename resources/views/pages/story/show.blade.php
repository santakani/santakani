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
    'has_share_buttons' => true,
])

@section('main')
    <div class="container-content">
        <img class="img-responsive img-rounded" src="{{ $story->image->large_file_url }}">

        <h1 class="page-header">{{ $story->text('title') }}</h1>

        <ul class="info list-inline text-muted">
            <li>{{ $story->created_at->formatLocalized(App\Localization\Languages::dateFormat()) }}</li>
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
                            <a href="report">
                                {{ trans('common.report') }}
                            </a>
                        </li>
                    </ul>
                </div><!-- /.dropdown -->
            </div>
        </div><!-- /.row -->

        <div id="page-content" class="page-content">{!! $story->html('content') !!}</div>

        @include('components.tag-list', [
            'tags' => $story->tags,
        ])

        @if ($story->user_id)
            <div class="author">
                <h3>{{ trans('common.author') }}</h3>
                <a class="link-unstyled" href="{{ $story->user->url }}">
                    <div class="row">
                        <div class="col-xs-3 col-sm-2">
                            <img class="avatar img-rounded img-responsive" src="{{ $story->user->medium_avatar_url }}">
                        </div>
                        <div class="col-xs-9 col-sm-10">
                            <div class="user-name text-lg">
                                {{ $story->user->name }}
                            </div>
                            <div class="user-description text-muted">
                                {{ $story->user->description }}
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endif
    </div>
@endsection
