@extends('layout.app')

@section('content')
<div id="picture-carousel" class="carousel">
  <img src="{{ $designer->getImage()->getThumbUrl() }}" />
  <img src="{{ $designer->getImage()->getThumbUrl() }}" />
  <img src="{{ $designer->getImage()->getThumbUrl() }}" />
  <img src="{{ $designer->getImage()->getThumbUrl() }}" />
  <img src="{{ $designer->getImage()->getThumbUrl() }}" />
  <img src="{{ $designer->getImage()->getThumbUrl() }}" />
</div>


<article id="designer-{{ $designer->id }}" class="designer container">
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
