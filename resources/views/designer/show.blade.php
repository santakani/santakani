@extends('layout.app')

@section('content')

@if (!Auth::guest())

<div class="container">
    <a href="{{ url('/designer/'.$designer->id.'/edit') }}"
        id="edit-button" class="btn btn-default pull-right">Edit</a>
</div>

@endif

<div id="picture-carousel" class="carousel">
  <img src="{{ $designer->getImage()->getThumbUrl() }}" />
  <img src="{{ $designer->getImage()->getThumbUrl() }}" />
  <img src="{{ $designer->getImage()->getThumbUrl() }}" />
  <img src="{{ $designer->getImage()->getThumbUrl() }}" />
  <img src="{{ $designer->getImage()->getThumbUrl() }}" />
  <img src="{{ $designer->getImage()->getThumbUrl() }}" />
</div>


<article id="designer-{{ $designer->id }}" class="designer container">
    <h1 class="title">{{ $designer->getTranslation()->name }}</h1>
    <div class="content">{!! $designer->getTranslation()->content !!}</div>
</article>
@endsection
