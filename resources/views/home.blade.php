@extends('layout.app')

@section('content')
<div class="container">
    @foreach ($designers as $designer)
        <p>{{ $designer->id }}</p>
        <p><img src="{{ $designer->getImage()->getThumbUrl() }}" /></p>
        <p>{{ $designer->getTranslation()->name }}</p>
        <p>{{ $designer->getTranslation()->content }}</p>
    @endforeach
</div>
@endsection
