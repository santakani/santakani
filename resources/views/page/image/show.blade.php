@extends('layout.app', [
    'title' => 'Images',
    'body_id' => 'image-show-page',
    'body_class' => 'image-show image show',
])

@section('main')
<div class="container">

    @if($errors->any())
        <div class="alert alert-warning" role="alert">{{$errors->first()}}</div>
    @endif

    <br>
    <p>
        <a href="{{ $image->file_urls['full'] }}">
            <img class="img-responsive" src="{{ $image->file_urls['large'] }}">
        </a>
    </p>
    <p>
        Parent page: <a href="{{ $image->parentPage->url }}">{{ $image->parentPage->text('name') }}</a>
        &nbsp;&nbsp;
        Author: <a href="{{ $image->user->url }}">{{ $image->user->name }}</a>
        &nbsp;&nbsp;
        Upload at: {{ $image->created_at }}
    </p>
    <br>
</div>
@endsection
