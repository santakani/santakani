@extends('layout.app', [
    'title' => $story->text('title') . ' - Story',
    'body_id' => 'story-show-page',
    'body_class' => 'story-show-page story-page show-page',
    'active_nav' => 'story',
])

@section('main')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h1 class="page-header">
                {{ $story->text('title') }}
            </h1>
            <div class="action-buttons">
                <a id="like-button" class="btn btn-default" href="#">
                    <i class="fa fa-heart-o fa-lg"></i> Like</a>
                @if ($can_edit)
                    <a id="edit-button" class="btn btn-default" href="{{ $story->url . '/edit' }}">
                        <i class="fa fa-pencil-square-o fa-lg"></i> Edit</a>
                    <a id="delete-button" class="btn btn-danger" href="#">
                        <i class="fa fa-trash-o fa-lg"></i> Delete</a>
                @endif
            </div>
            @if ($story->image)
                <img src="{{ $story->image->file_urls['medium'] }}">
            @endif
            @include('component.tag-list', [
                'tags' => $story->tags,
                'style' => 'plain',
            ])
            <div class="content">
                {!! $story->text('content') !!}
            </div>
        </div>
        <div class="col-md-4">

        </div>
    </div>

</div>
@endsection
