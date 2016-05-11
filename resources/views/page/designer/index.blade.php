@extends('layout.app', [
    'title' => 'Designers',
    'body_id' => 'designer-index-page',
    'body_class' => 'designer-index index',
])

@section('main')
<div id="story-list" class="container">
    <div class="grid row">
        @foreach ($designers as $designer)
            <article id="story-{{ $designer->id }}" class="story grid-item col-xs-12 col-sm-6 col-md-4 col-lg-3">
                @if ($image = $designer->image)
                    <a href="{{ $designer->url }}">
                        <img class="featured-image" src="{{ $image->file_urls['thumb'] }}" />
                    </a>
                @endif
                <h3 class="title"><a href="{{ $designer->url }}">
                    {{ $designer->name }}</a></h3>
                <div class="content">{!! $designer->content !!}</div>
                <div class="expand-button btn btn-sm btn-default">
                    <span class="more"><i class="fa fa-angle-down"></i> More</span>
                    <span class="less"><i class="fa fa-angle-up"></i> Less</span>
                </div>
            </article>
        @endforeach
    </div><!-- .grid.row -->
</div><!-- #story-list.container -->
@endsection
