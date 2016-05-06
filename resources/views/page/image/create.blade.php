@extends('layout.app', [
    'title' => 'Upload Image',
    'body_id' => 'image-create-page',
    'body_class' => 'image-create create',
])

@section('main')
<form class="form-horizontal" action="{{ url('image') }}" method="post"
    enctype="multipart/form-data">
    <div class="container">
        @if($errors->any())
            <div class="alert alert-warning" role="alert">{{$errors->first()}}</div>
        @endif
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="file" name="image" accept="image/*">
        <button type="submit">Upload</button>
    </div>
</form>
@endsection
