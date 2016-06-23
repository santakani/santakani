@extends('layout.app', [
    'title' => 'Designers',
    'body_id' => 'designer-index-page',
    'body_classes' => ['designer-index-page', 'index-page', 'designer-page'],
    'active_nav' => 'designer',
])

@section('main')
<div class="container">
    <form id="designer-filter" class="list-filter" action="/designer" method="get">
        @include('component.tag-filter', ['selected' => app('request')->input('tag_id')])
    </form>
    <div id="designer-list" class="row">
        @foreach ($designers as $designer)
            <div class="col-sm-12 col-md-6">
                <article id="designer-{{ $designer->id }}" class="designer material-card"
                    data-id="{{ $designer->id }}">
                    <a href="{{ $designer->url }}">
                        <div class="cover-image" style="background-image:url({{ $designer->image_id ? $designer->image->file_urls['medium'] : '' }})">
                            <img class="logo-image" src="{{ $designer->logo_id ? $designer->logo->file_urls['thumb'] : '' }}" />
                        </div>
                        <div class="text">
                            <h1>{{ $designer->text('name') }}<br>
                                <small>{{ $designer->text('tagline') }}</small></h1>
                            <div class="excerpt">{{ $designer->excerpt('content') }}</div>
                        </div>
                    </a>
                </article>
            </div>
        @endforeach
    </div><!-- #designer-list -->
    <div class="text-center">
        {!! $designers->appends(app('request')->all())->links() !!}
    </div>
</div><!-- .container -->
@endsection
