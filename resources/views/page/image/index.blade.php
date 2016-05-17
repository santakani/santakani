@extends('layout.app', [
    'title' => 'Images',
    'body_id' => 'image-index-page',
    'body_class' => 'image-index image index',
])

@section('main')
<div class="container">

    @if($errors->any())
        <div class="alert alert-warning" role="alert">{{$errors->first()}}</div>
    @endif

    @foreach ($images as $image)
        <a href="{{ $image->url }}">
            <img src="{{ $image->file_urls['thumb'] }}">
        </a>
    @endforeach

</div>
@endsection
