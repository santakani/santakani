@extends('layouts.app', [
    'title' => trans('common.tags'),
    'body_id' => 'tag-index-page',
    'body_classes' => ['tag-index-page', 'tag-page', 'index-page'],
])

@section('main')

<div class="container">

    <h1 class="text-center">
        {{ trans('common.tags') }}
    </h1>

    <form class="form-inline text-center" action="/tag" method="get">
        <input name="search" value="{{ request()->input('search') }}"
               type="search" class="form-control" placeholder="&#xf4a4; {{ trans('common.search') }}">
    </form>

    <br>

    <div id="tag-list" class="tag-list row small-gutter">
        @foreach ($tags as $tag)
            <div class="col-xs-6 col-sm-4 col-md-3">
                <article id="tag-{{ $tag->id }}" class="tag" data-id="{{ $tag->id }}">
                    <a href="/tag/{{ $tag->id }}">
                        @if ($tag->image_id)
                            <img class="cover-image" src="{{ $tag->image->fileUrl('thumb') }}" width="300" height="300" />
                        @else
                            <img class="cover-image" src="/img/placeholder/square.png" width="300" height="300" />
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
