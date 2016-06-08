@extends('layout.app', [
    'title' => 'Settings',
    'body_id' => 'user-settings-page',
    'body_class' => 'user-settings-page user-page',
    'active_nav' => 'user',
])

@section('main')
@if($errors->any())
<h4>{{$errors->first()}}</h4>
@endif
@endsection
