@extends('layout.app', [
    'title' => $designer->getTranslation()->name . ' - Designer',
    'body_id' => 'designer-page',
    'body_class' => 'designer-page',
])

@section('content')

@if (!Auth::guest())

<div class="container">
    <a href="{{ url('/designer/'.$designer->id.'/edit') }}"
        id="edit-button" class="btn btn-default pull-right">Edit</a>
</div>

@endif

<div id="picture-carousel" class="carousel">

@foreach ($designer->getImages() as $image)

    <div class="picture-thumb" data-src="{{ url($image->getUrl()) }}"
        data-thumb="{{ url($image->getThumbUrl()) }}"
        style="background-image:url({{ url($image->getThumbUrl()) }})"></div>

@endforeach

</div>


<article id="designer-{{ $designer->id }}" class="designer container">
    <h1 class="title">{{ $designer->getTranslation()->name }}</h1>
    <div class="content">{!! $designer->getTranslation()->content !!}</div>
</article>
@endsection
