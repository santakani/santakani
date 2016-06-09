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
            <label for="input-name" class="col-sm-2 control-label">
                Title
            </label>

            <div class="col-sm-10 col-md-8">
                <input name="name" value="{{ old('title')?old('title'):$story->text('title', 'en') }}"
                    id="input-name" class="form-control" type="text" maxlength="255">
            </div>
        </div>

        <div id="image-form-group" class="form-group">
            <label class="col-sm-2 control-label">
                Cover image
            </label>

            <div class="col-sm-10 col-md-8">
                <div id="cover-editor" class="cover-editor">
                    <p><button type="button" class="btn btn-default"><i class="fa fa-picture-o"></i> Choose</button></p>
                    @if ($image = App\Image::find(old('image_id')))
                        @include('component.image-preview', ['image' => $image])
                    @elseif ($story->image_id)
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
                <textarea id="input-content" name="content">{{
                    old('content')?old('content'):$story->text('content', 'en')
                }}</textarea>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">
                Gallery
            </label>

            <div class="col-sm-10 col-md-8">
                <div id="gallery-editor" class="gallery-editor">
                    <p><button type="button" class="btn btn-default"><i class="fa fa-picture-o"></i> Choose</button></p>
                    <div class="images clearfix">
                        @if ( count( old('gallery_image_ids') ) )
                            @foreach (\App\Image::find( old('gallery_image_ids') ) as $image)
                                @include('component.image-preview', ['image' => $image])
                            @endforeach
                        @elseif ( count( $story->gallery_images ) )
                            @foreach ($story->gallery_images as $image)
                                @include('component.image-preview', ['image' => $image])
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">Tags</label>

            <div class="col-sm-10 col-md-8">
                <select name="tag_ids[]" class="tag-select form-control" style="width: 100%" multiple="multiple">
                    @if ( count( old('tag_ids') ) )
                        @foreach (\App\Tag::find( old('tag_ids') ) as $tag)
                            <option value="{{ $tag->id }}" selected="selected">
                                {{ $tag->text('name') }}
                            </option>
                        @endforeach
                    @elseif ( count( $story->tags ) )
                        @foreach ($story->tags as $tag)
                            <option value="{{ $tag->id }}" selected="selected">
                                {{ $tag->text('name') }}
                            </option>
                        @endforeach
                    @endif
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
