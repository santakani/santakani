@extends('layout.app', [
    'title' => 'Images',
    'body_id' => 'image-index-page',
    'body_class' => 'image-index image index',
])

@section('main')
<div class="container">
    @foreach ($images as $image)
        @if(substr($image->mime_type, 0, 5) === 'image')
            <a href="{{ $image->url }}">
                <img src="{{ $image->file_urls['thumb'] }}">
            </a>
        @else
            <!-- Video -->
        @endif
    @endforeach
</div>
@endsection
