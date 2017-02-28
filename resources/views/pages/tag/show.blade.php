@extends('layouts.app', [
    'title' => $tag->text('name') . ' - ' . trans('common.tag'),
    'body_id' => 'tag-show-page',
    'body_classes' => ['tag-show-page', 'tag-page', 'show-page'],
    'og_title' => $tag->text('name'),
    'og_url' => $tag->url,
    'og_description' => $tag->excerpt('description'),
    'og_image' => empty($tag->image_id)?'':$tag->image->fileUrl('medium'),
])

@section('main')

<header>
    <div class="container">

        <div class="text-center">
            @if ($tag->image_id)
                <img class="cover" src="{{ $tag->image->thumb_file_url }}" width="300" height="300" srcset="{{ $tag->image->largethumb_file_url }} 2x">
            @endif
            <h1>{{ $tag->text('name') }}</h1>

            <div class="action-bar">
                <div class="action">
                    @include('components.buttons.like', ['likeable' => $tag])
                </div><!-- /.action -->

                @if (Auth::check() && Auth::user()->can('edit-tag', $tag))
                    <div class="action">
                        <a class="btn btn-icon" href="{{ $tag->url . '/edit' }}" title="{{ trans('common.edit') }}">
                            <i class="icon ion-ios-compose-outline"></i>
                        </a>
                    </div><!-- /.action -->
                @endif
                @if (Auth::user()->can('delete-tag', $tag))
                    <div class="action">
                        <a id="delete-button" class="btn btn-icon" href="#" title="{{ trans('common.delete') }}">
                            <i class="icon ion-ios-close-outline"></i>
                        </a>
                    </div><!-- /.action -->
                @endif
            </div><!-- /.action-bar -->
        </div><!-- /.text-center -->

        <div class="description">{!! nl2br(htmlspecialchars($tag->text('description'))) !!}</div>

    </div><!-- .container -->
</header>

<div class="container">
    <ul id="tabs" class="nav nav-tabs nav-justified">
        <li class="{{ $tab === 'designs' ? 'active' : '' }}">
            <a href="{{ $tag->url }}?tab=designs">
                {{ trans('design.designs') }}
            </a>
        </li>
        <li class="{{ $tab === 'designers' ? 'active' : '' }}">
            <a href="{{ $tag->url }}?tab=designers">
                {{ trans('designer.designers') }}
            </a>
        </li>
        <li class="{{ $tab === 'places' ? 'active' : '' }}">
            <a href="{{ $tag->url }}?tab=places">
                {{ trans('place.places') }}
            </a>
        </li>
        <li class="{{ $tab === 'stories' ? 'active' : '' }}">
            <a href="{{ $tag->url }}?tab=stories">
                {{ trans('story.stories') }}
            </a>
        </li>
    </ul>

    @if ($tab === 'designs')
        <div class="row">
            @foreach ($likeables as $design)
                <div class="col-sm-6 col-md-4">
                    @include('components.cards.design-card', ['design' => $design])
                </div>
            @endforeach
        </div>
    @elseif ($tab === 'designers')
        <div class="row">
            @foreach ($likeables as $designer)
                <div class="col-sm-6 col-md-4">
                    @include('components.cards.designer-card', ['designer' => $designer])
                </div>
            @endforeach
        </div>
    @elseif ($tab === 'stories')
        <div class="row">
            @foreach ($likeables as $place)
                <div class="col-sm-6 col-md-4">
                    @include('components.cards.place-card', ['place' => $place])
                </div>
            @endforeach
        </div>
    @elseif ($tab === 'stories')
        @each('components.cards.story-card', $likeables, 'story')
    @endif

    <div class="text-center">
        {{ $likeables->appends(app('request')->all())->links() }}
    </div><!-- /.text-center -->
</div>

@endsection
