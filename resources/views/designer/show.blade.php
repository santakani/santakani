@extends('layout.app')

@section('content')
<article id="story-{{ $designer->id }}" class="story grid-item col-xs-12 col-sm-6 col-md-4 col-lg-3">
    <img class="featured-image" src="{{ $designer->getImage()->getThumbUrl() }}" />
    <h3 class="title"><a href="{{ url('/designer/' . $designer->id) }}">
        {{ $designer->getTranslation()->name }}</a></h3>
    <div class="content">{!! $designer->getTranslation()->content !!}</div>
    <div class="expand-button btn btn-sm btn-default">
        <span class="more"><i class="fa fa-angle-down"></i> More</span>
        <span class="less"><i class="fa fa-angle-up"></i> Less</span>
    </div>
</article>
@endsection
