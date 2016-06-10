@extends('layout.app', [
    'title' => 'Edit: ' . $designer->name,
    'body_id' => 'designer-edit-page',
    'body_class' => 'designer-edit edit',
    'active_nav' => 'designer',
])

@section('main')
<div class="container">
    <form id="designer-edit-form" class="form-horizontal" action="{{ $designer->url }}"
        data-id="{{ $designer->id }}">

        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10 col-md-8">
                <div class="alert alert-warning" style="display:none;" role="alert"></div>
            </div>
        </div>

        <div class="form-group">
            <label for="input-name" class="col-sm-2 control-label">
                Name
            </label>

            <div class="col-sm-10 col-md-8">
                <input name="name" type="text" class="form-control" id="input-name"
                    value="{{ $designer->text('name', 'en') }}">
            </div>
        </div>

        <div id="image-form-group" class="form-group">
            <label class="col-sm-2 control-label">
                Cover image
            </label>

            <div class="col-sm-10 col-md-8">
                <div id="cover-editor" class="cover-editor">
                    <p><button type="button" class="btn btn-default"><i class="fa fa-picture-o"></i> Choose</button></p>
                    @if ($designer->image_id)
                        @include('component.image-preview', ['image' => $designer->image])
                    @else
                        @include('component.image-preview')
                    @endif
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="input-tagline" class="col-sm-2 control-label">
                Tagline
            </label>

            <div class="col-sm-10 col-md-8">
                <input type="text" name="tagline" class="form-control" id="input-tagline"
                    placeholder="Express design philosophy in short" maxlength="255"
                    value="{{ $designer->text('tagline', 'en') }}">
            </div>
        </div>

        <div class="form-group">
            <label for="input-content" class="col-sm-2 control-label">
                Content
            </label>

            <div class="col-sm-10 col-md-8">
                <textarea name="content" class="form-control tinymce"
                    id="input-content">{{ $designer->text('content', 'en') }}</textarea>
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
                        @foreach ($designer->gallery_images as $image)
                            @include('component.image-preview', ['image' => $image])
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">
                City
            </label>

            <div class="col-sm-4 col-md-3">
                <select name="city_id" id="city-select" class="city-select form-control">
                    @if (!empty($place->city_id))
                        <option value="{{ $place->city_id }}" selected="selected">{{ $place->city->full_name }}</option>
                    @endif
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">Tags</label>

            <div class="col-sm-10 col-md-8">
                <select name="tag_ids[]" class="tag-select" style="width: 100%" multiple="multiple">
                    @foreach ($designer->tags as $tag)
                        <option value="{{ $tag->id }}" selected="selected">{{ $tag->text('name') }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="input-email" class="col-sm-2 control-label">Email</label>
            <div class="col-sm-10 col-md-8">
                <input name="email" value="{{ $designer->email }}" type="email"
                    maxlength="255" class="form-control" id="input-email">
            </div>
        </div>

        <div class="form-group">
            <label for="input-website" class="col-sm-2 control-label">Website</label>
            <div class="col-sm-10 col-md-8">
                <input name="website" value="{{ $designer->website }}" type="url"
                    maxlength="255" class="form-control" id="input-website">
            </div>
        </div>

        <div class="form-group">
            <label for="input-facebook" class="col-sm-2 control-label">Facebook</label>
            <div class="col-sm-10 col-md-8">
                <input name="facebook" value="{{ $designer->facebook }}" type="url"
                    maxlength="255" class="form-control" id="input-facebook">
            </div>
        </div>

        <div class="form-group">
            <label for="input-twitter" class="col-sm-2 control-label">Twitter</label>
            <div class="col-sm-10 col-md-8">
                <input name="twitter" value="{{ $designer->twitter }}" type="url"
                    maxlength="255" class="form-control" id="input-twitter">
            </div>
        </div>

        <div class="form-group">
            <label for="input-google-plus" class="col-sm-2 control-label">Google+</label>
            <div class="col-sm-10 col-md-8">
                <input name="google_plus" value="{{ $designer->google_plus }}" type="url"
                    maxlength="255" class="form-control" id="input-google-plus">
            </div>
        </div>

        <div class="form-group">
            <label for="input-instagram" class="col-sm-2 control-label">Instagram</label>
            <div class="col-sm-10 col-md-8">
                <input name="instagram" value="{{ $designer->instagram }}" type="url"
                    maxlength="255" class="form-control" id="input-instagram">
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
