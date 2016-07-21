@extends('layouts.app', [
    'title' => trans('common.tags'),
    'body_id' => 'tag-index-page',
    'body_classes' => ['tag-index-page', 'tag-page', 'index-page'],
])

@section('main')
<div class="container">

    @if($errors->any())
        <div class="alert alert-warning" role="alert">{{ $errors->first() }}</div>
    @endif

    <h1 class="page-header">
        {{ trans('common.tags') }}
        @if (Auth::check() && Auth::user()->can('create-tag'))
            <a class="btn btn-default" href="/tag/create">
                <i class="fa fa-plus"></i> {{ trans('common.create') }}
            </a>
        @endif
    </h1>

    <form class="form-inline text-right" action="/tag" method="get">
        <input name="search" value="{{ request()->input('search') }}"
               type="search" class="form-control">
        <button type="submit" class="btn btn-primary">
            <i class="fa fa-search"></i> {{ trans('common.search') }}
        </button>
    </form>

    <br>

    <div id="tag-list" class="tag-list row">
        @foreach ($tags as $tag)
            <div class="col-xs-6 col-sm-4 col-md-3">
                <article id="tag-{{ $tag->id }}" class="tag" data-id="{{ $tag->id }}">
                    <a href="/tag/{{ $tag->id }}">
                        @if ($tag->image_id)
                            <img class="cover-image" src="{{ $tag->image->url('thumb') }}" width="300" height="300" />
                        @else
                            <img class="cover-image" src="/img/placeholder/blank/300x300.svg" width="300" height="300" />
                        @endif
                        <div class="text">
                            <h3>{{ $tag->text('name') }}</h3>
                        </div>
                    </a>
                </article>
            </div>
        @endforeach
    </div><!-- #tag-list -->

    <div class="text-center">
        {!! $tags->appends(app('request')->all())->links() !!}
    </div>

</div>
@endsection
