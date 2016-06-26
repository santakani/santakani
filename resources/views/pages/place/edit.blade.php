@extends('layout.app', [
    'title' => 'Edit: ' . $place->name,
    'body_id' => 'place-edit-page',
    'body_classes' => ['place-edit-page', 'place-page', 'edit-page'],
    'active_nav' => 'place',
])

@section('main')
<div class="container">
    <form id="place-edit-form" class="form-horizontal" action="{{ $place->url }}"
        data-id="{{ $place->id }}">

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
                <input id="input-name" class="form-control" type="text"
                    name="name" value="{{ $place->text('name', 'en') }}"
                    placeholder="Name of place" maxlength="255">
            </div>
        </div>

        <div class="form-group">
            <label for="place-type-select" class="col-sm-2 control-label">
                Type
            </label>

            <div class="col-sm-4 col-md-3">
                @include('components.place-type-select', [
                    'selected' => $place->type,
                    'required' => true,
                ])
            </div>
        </div>

        <div id="image-form-group" class="form-group">
            <label class="col-sm-2 control-label">
                Cover image
            </label>

            <div class="col-sm-10 col-md-8">
                <div id="cover-editor" class="cover-editor">
                    <p><button type="button" class="btn btn-default"><i class="fa fa-picture-o"></i> Choose</button></p>
                    @if ($place->image_id)
                        @include('components.image-preview', ['image' => $place->image])
                    @else
                        @include('components.image-preview')
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
                    old('content')?old('content'):$place->text('content', 'en')
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
                        @foreach ($place->gallery_images as $image)
                            @include('components.image-preview', ['image' => $image])
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
                        <option value="{{ $place->city_id }}" selected="selected">
                            {{ $place->city->text('name') }}, {{ $place->country->text('name') }}
                        </option>
                    @endif
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="address-input" class="col-sm-2 control-label">
                Address
            </label>

            <div class="col-sm-8 col-md-6">
                <input id="address-input" class="form-control" type="text"
                    name="address" value="{{ $place->address }}" maxlength="255">
            </div>
            <div class="col-sm-2">
                <button id="search-coordinate-button" class="btn btn-info btn-block" type="button">
                    <i class="fa fa-map-marker fa-lg"></i> Mark On Map
                </button>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">
                Coordinates
            </label>
            <div class="col-sm-10 col-md-8">
                @include('components.coordinate-select', [
                    'latitude' => $place->latitude,
                    'longitude' => $place->longitude,
                ])
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">Tags</label>

            <div class="col-sm-10 col-md-8">
                <select name="tag_ids[]" class="tag-select" style="width: 100%" multiple="multiple">
                    @foreach ($place->tags as $tag)
                        <option value="{{ $tag->id }}" selected="selected">
                            {{ $tag->text('name') }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="phone-input" class="col-sm-2 control-label">
                Phone
            </label>
            <div class="col-sm-10 col-md-8">
                <input name="phone" value="{{ $place->phone }}" type="tel"
                       id="phone-input" class="form-control" maxlength="255">
            </div>
        </div>

        <div class="form-group">
            <label for="input-email" class="col-sm-2 control-label">Email</label>
            <div class="col-sm-10 col-md-8">
                <input name="email" value="{{ $place->email }}" type="email"
                    maxlength="255" class="form-control" id="input-email">
            </div>
        </div>

        <div class="form-group">
            <label for="input-website" class="col-sm-2 control-label">Website</label>
            <div class="col-sm-10 col-md-8">
                <input name="website" value="{{ $place->website }}" type="url"
                    maxlength="255" class="form-control" id="input-website">
            </div>
        </div>

        <div class="form-group">
            <label for="input-facebook" class="col-sm-2 control-label">Facebook</label>
            <div class="col-sm-10 col-md-8">
                <input name="facebook" value="{{ $place->facebook }}" type="url"
                    maxlength="255" class="form-control" id="input-facebook">
            </div>
        </div>

        <div class="form-group">
            <label for="input-google-plus" class="col-sm-2 control-label">Google+</label>
            <div class="col-sm-10 col-md-8">
                <input name="google_plus" value="{{ $place->google_plus }}" type="url"
                    maxlength="255" class="form-control" id="input-google-plus">
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
    @include('components.image-manager')
@endpush
