@extends('layout.app', [
    'title' => 'Edit: ' . $story->text('title'),
    'body_id' => 'story-edit-page',
    'body_class' => 'story-edit-page story-page edit-page',
    'active_nav' => 'story',
])

@section('header')
<header>
    <div class="container">
        <div class="row">
            <div class="col-sm-offset-2 sol-sm-10 col-md-8">
                <h1 class="page-header">Edit Story: {{ $story->text('title') }}</h1>
            </div>
        </div>
    </div>
</header>
@endsection

@section('main')
<div class="container">
    <form id="story-edit-form" class="form-horizontal" action="{{ $story->url }}"
        data-id="{{ $story->id }}">

        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10 col-md-8">
                <div class="alert alert-warning" style="display:none;" role="alert"></div>
            </div>
        </div>

        <div class="form-group">
            <label for="title-input" class="col-sm-2 control-label">
                Title
            </label>

            <div class="col-sm-10 col-md-8">
                <input name="translations[en][title]" value="{{ $story->text('title', 'en') }}"
                    id="title-input" class="form-control" type="text" maxlength="255">
            </div>
        </div>

        <div id="image-form-group" class="form-group">
            <label class="col-sm-2 control-label">
                Cover image
            </label>

            <div class="col-sm-10 col-md-8">
                <div id="cover-editor" class="cover-editor">
                    <p><button type="button" class="btn btn-default"><i class="fa fa-picture-o"></i> Choose</button></p>
                    @if ($story->image_id)
                        @include('component.image-preview', ['image' => $story->image])
                    @else
                        @include('component.image-preview')
                    @endif
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="input-content" class="col-sm-2 control-label">
                Content
            </label>

            <div class="col-sm-10 col-md-8">
                <textarea id="input-content" name="translations[en][content]">{{
                    $story->text('content', 'en')
                }}</textarea>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">Tags</label>

            <div class="col-sm-10 col-md-8">
                <select name="tag_ids[]" class="tag-select form-control" style="width: 100%" multiple="multiple">
                    @foreach ($story->tags as $tag)
                        <option value="{{ $tag->id }}" selected="selected">{{ $tag->text('name') }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">Save</button>
            </div>
        </div>

    </form>
</div><!-- .container -->
@endsection

@push('templates')
    @include('template.image-preview')
@endpush

@push('modals')
    @include('component.image-manager')
@endpush
