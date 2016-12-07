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
    <div class="article-list-header">
        <div class="container">
            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}">{{ trans('common.home') }}</a></li>
                <li><a href="{{ url('tag') }}">{{ trans('common.tags') }}</a></li>
                <li class="active">{{ $tag->text('name') }}</li>
            </ol>

            <div class="header-content">
                @if ($tag->image_id)
                    <img class="cover" src="{{ $tag->image->thumb_file_url }}" srcset="{{ $tag->image->largethumb_file_url }} 2x">
                @endif
                <div class="text">
                    <h1>
                        {{ $tag->text('name') }}

                        @if (Auth::check() && Auth::user()->can('edit-tag', $tag))
                            <div class="btn-group pull-right">
                                <a id="edit-button" class="btn btn-default" href="{{ url()->current() . '/edit' }}">
                                    <i class="fa fa-pencil"></i> {{ trans('common.edit') }}
                                </a>
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    @if (Auth::user()->can('delete-tag', $tag))
                                        <li><a id="delete-button" href="#"><i class="fa fa-fw fa-trash"></i> {{ trans('common.delete') }}</a></li>
                                    @endif
                                </ul>
                            </div><!--/.btn-group -->
                        @endif
                    </h1>
                    <p>@include('components.buttons.like', ['likeable' => $tag])</p>
                    <br>
                    <p>{!! nl2br(htmlspecialchars($tag->text('description'))) !!}</p>
                </div><!-- .text -->
            </div><!-- .header-content -->
        </div><!-- .container -->
    </div><!-- .article-list-header -->
@endsection

@section('main')

    <section id="story-list" class="article-list">
        <h2 class="heading">{{ trans('story.stories') }}</h2>
        <div class="list">
            @foreach ($stories as $story)
                <article>
                    <a href="{{ $story->url }}">
                        <div class="cover">
                            @if ($story->image_id)
                                <img class="image" src="{{ $story->image->thumb_file_url }}"
                                    srcset="{{ $story->image->largethumb_file_url }} 2x"/>
                            @endif
                        </div>
                        <div class="text">
                            <div class="inner">
                                <h3>{{ $story->title }}</h3>
                                <p class="excerpt">{{ $story->excerpt('content') }}</p>
                            </div>
                        </div>
                    </a>
                </article>
            @endforeach
            <article class="more-button">
                <a href="{{ url('story?tag_id='.$tag->id) }}">
                    <i class="fa fa-2x fa-plus-square-o"></i>
                    <br>
                    {{ trans('common.more') }}
                </a>
            </article>
        </div>
    </section>

    <section id="designer-list" class="article-list">
        <h2 class="heading">{{ trans('designer.designers') }}</h2>
        <div class="list">
            @foreach ($designers as $designer)
                <article>
                    <a href="{{ $designer->url }}">
                        <div class="cover">
                            @if ($designer->image_id)
                                <img class="image" src="{{ $designer->image->thumb_file_url }}"
                                    srcset="{{ $designer->image->largethumb_file_url }} 2x"/>
                            @endif
                            @if ($designer->logo_id)
                                <img class="logo" src="{{ $designer->logo->small_file_url }}"/>
                            @endif
                        </div>
                        <div class="text">
                            <div class="inner">
                                <h2>{{ $designer->text('name') }}<br></h2>
                                <div class="tagline text-muted">{{ $designer->text('tagline') }}</div>
                                <div class="excerpt">{{ $designer->excerpt('content') }}</div>
                            </div>
                        </div>
                    </a>
                </article>
            @endforeach
            <article class="more-button">
                <a href="{{ url('designer?tag_id='.$tag->id) }}">
                    <i class="fa fa-2x fa-plus-square-o"></i>
                    <br>
                    {{ trans('common.more') }}
                </a>
            </article>
        </div>
    </section>

    <section id="place-list" class="article-list">
        <h2 class="heading">{{ trans('place.places') }}</h2>
        <div class="list">
            @foreach ($places as $place)
                <article>
                    <a href="{{ $place->url }}">
                        <div class="cover">
                            @if ($place->image_id)
                                <img class="image" src="{{ $place->image->thumb_file_url }}"
                                    srcset="{{ $place->image->largethumb_file_url }} 2x"/>
                            @endif
                        </div>
                        <div class="text">
                            <div class="inner">
                                <h3>{{ $place->name }} <small>{{ $place->city->full_name }}</small></h3>

                                <p class="excerpt">{{ $place->excerpt('content') }}</p>
                            </div>
                        </div>
                    </a>
                </article>
            @endforeach
            <article class="more-button">
                <a href="{{ url('place?tag_id='.$tag->id) }}">
                    <i class="fa fa-2x fa-plus-square-o"></i>
                    <br>
                    {{ trans('common.more') }}
                </a>
            </article>
        </div>
    </section>

@endsection
