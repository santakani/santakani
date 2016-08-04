@extends('layouts.app', [
    'title' => 'Images',
    'body_id' => 'image-show-page',
    'body_classes' => ['image-show-page', 'show-page', 'image-page'],
])

@section('main')
<div class="container">

    @if($errors->any())
        <div class="alert alert-warning" role="alert">{{$errors->first()}}</div>
    @endif

    <br>
    <p>
        <a href="{{ $image->fileUrl('full') }}">
            <img class="img-responsive" src="{{ $image->fileUrl('large') }}">
        </a>
    </p>
    <p>
        Parent page:
        @if ( count( $image->parentPage ) )
            <a href="{{ $image->parentPage->url }}">{{ $image->parentPage->text('name') }}</a>
        @else
            None
        @endif
        &nbsp;&nbsp;
        Author:
        @if ( count( $image->user ) )
            <a href="{{ $image->user->url }}">{{ $image->user->name }}</a>
        @else
            Unknown
        @endif
        &nbsp;&nbsp;
        Upload at: {{ $image->created_at }}
    </p>
    <br>
</div>
@endsection
