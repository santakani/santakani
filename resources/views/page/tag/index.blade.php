@extends('layout.app', [
    'title' => 'Tags',
    'body_id' => 'tag-index-page',
    'body_class' => 'tag-index-page tag-page index-page',
])

@section('main')
<div class="container">

    @if($errors->any())
        <div class="alert alert-warning" role="alert">{{$errors->first()}}</div>
    @endif

    <h1 class="page-header">Tags</h1>
    <ol>
    @foreach ($tags as $tag)
        <li>{{ $tag->text('name') }}</li>
    @endforeach
    </ol>

    <br>

</div>
@endsection
