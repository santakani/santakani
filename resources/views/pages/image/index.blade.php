@extends('layouts.app', [
    'title' => 'Images',
    'body_id' => 'image-index-page',
    'body_classes' => ['image-index-page', 'index-page', 'image-page'],
])

@section('main')
<div class="container">

    @if($errors->any())
        <div class="alert alert-warning" role="alert">{{$errors->first()}}</div>
    @endif

    @foreach ($images as $image)
        <a href="{{ $image->url }}">
            <img src="{{ $image->url('thumb') }}">
        </a>
    @endforeach

</div>
@endsection
