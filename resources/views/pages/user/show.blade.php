@extends('layouts.app', [
    'title' => $user->name . ' - ' . trans('common.user'),
    'body_id' => 'user-show-page',
    'body_classes' => ['user-show-page', 'user-page', 'show-page'],
])

@section('header')

@endsection

@section('main')
    <div class="container">
        <br/><br/>
        <div class="row">
            <div class="col-sm-4 col-md-3">
                <img class="img-rounded img-responsive" src="{{ $user->avatar(300) }}" width="300" height="300"/>
                <h1>{{ $user->name }}</h1>
                <p class="text-muted">{{ $user->description }}</p>
                <p><i class="fa fa-clock-o"></i> {{ $user->created_at }}</p>
            </div>
            <div class="col-sm-8 col-md-9">
                <div id="story-list" class="story-list row">
                    @foreach ($stories as $story)
                        <div class="col-sm-6 col-md-4">
                            <article id="story-{{ $story->id }}" class="story material-card" data-id="{{ $story->id }}">
                                <a href="{{ $story->url }}">
                                    @if ($image = $story->image)
                                        <img class="cover-image" src="{{ $image->url('thumb') }}" />
                                    @else
                                        <img class="cover-image" src="http://placehold.it/300x300?text=NO+IMAGE" />
                                    @endif
                                    <div class="shadow"></div>
                                    <div class="text">
                                        <h1>{{ $story->title }}</h1>
                                        {{ $story->excerpt('content') }}
                                    </div>
                                </a>
                            </article>
                        </div>
                    @endforeach
                </div><!-- #story-list -->
                <div class="text-center">
                    {!! $stories->appends(app('request')->all())->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
