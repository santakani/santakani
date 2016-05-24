@extends('layout.app', [
    'title' => 'Cities',
    'body_id' => 'city-index-page',
    'body_class' => 'city-index-page city-page index-page',
])

@section('main')
<div class="container">

    @if($errors->any())
        <div class="alert alert-warning" role="alert">{{$errors->first()}}</div>
    @endif

    <h1 class="page-header">Cities</h1>
    <ol>
    @foreach ($cities as $city)
        <li>{{ $city->text('name') }}, {{ $city->country->text('name') }}</li>
    @endforeach
    </ol>

    <br>

</div>
@endsection
