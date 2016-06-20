@extends('layout.app', [
    'title' => 'Tags',
    'body_id' => 'tag-index-page',
    'body_class' => 'tag-index-page tag-page index-page',
])

@section('main')
<div class="container">

    @if($errors->any())
        <div class="alert alert-warning" role="alert">{{ $errors->first() }}</div>
    @endif

    <h1 class="page-header">
        Tags
        <a class="btn btn-default" href="/tag/create">
            <i class="fa fa-plus"></i> New Tag
        </a>
    </h1>

    <div id="tag-list" class="tag-list row">
        @foreach ($tags as $tag)
            <div class="col-xs-6 col-sm-4 col-md-3">
                <article id="tag-{{ $tag->id }}" class="tag" data-id="{{ $tag->id }}">
                    <a href="/tag/{{ $tag->id }}">
                        @if ($tag->image_id)
                            <img class="cover-image" src="{{ $tag->image->getFileUrl('thumb') }}" width="300" height="300" />
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
