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
                    value="{{ old('name')===null?$designer->text('name', 'en'):old('name') }}"
                    placeholder="Name of designer or design brand"
                    required>
            </div>
        </div>

        <div id="image-form-group" class="form-group">
            <label class="col-sm-2 control-label">
                Cover image
            </label>

            <div class="col-sm-10 col-md-8">
                <div id="cover-editor" class="cover-editor">
                    <p><button type="button" class="btn btn-default"><i class="fa fa-picture-o"></i> Choose</button></p>
                    @if ($image = App\Image::find(old('image')))
                        @include('component.image-preview', ['image' => $image])
                    @elseif ($designer->image_id)
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
                    value="{{old('tagline')===null?$designer->text('tagline', 'en'):old('tagline')}}">
            </div>
        </div>

        <div class="form-group">
            <label for="input-content" class="col-sm-2 control-label">
                Content
            </label>

            <div class="col-sm-10 col-md-8">
                <textarea name="content" class="form-control tinymce" id="input-content"
                    placeholder="Introduce your unique design story..." rows="5">{{
                    old('content')===null?$designer->text('content', 'en'):old('content')
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
                        @elseif ( count( $designer->gallery_images ) )
                            @foreach ($designer->gallery_images as $image)
                                @include('component.image-preview', ['image' => $image])
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">

            <?php
                $country = null;
                $city = null;

                if (old('city_id')) {
                    $city = \App\City::find(old('city_id'));
                } elseif ($designer->city_id) {
                    $city = \App\City::find($designer->city_id);
                }

                if (!empty($city)) {
                    $country = $city->country;
                }
            ?>

            <label class="col-sm-2 control-label">
                Country/region
            </label>

            <div class="col-sm-4 col-md-3">
                <select class="country-select">
                    @if (!empty($country))
                        <option value="{{ $country->id }}" selected="selected">
                            {{ $country->text('name') }}
                        </option>
                    @endif
                </select>
            </div>

            <label class="col-sm-2 control-label">
                City
            </label>

            <div class="col-sm-4 col-md-3">
                <select name="city_id" class="city-select">
                    @if (!empty($city))
                        <?php $city?>
                        <option value="{{ $city->id }}" selected="selected">
                            {{ $city->text('name') }}
                        </option>
                    @endif
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">Tags</label>

            <div class="col-sm-10 col-md-8">
                <select name="tag_ids[]" class="tag-select" style="width: 100%" multiple="multiple">
                    @if ( count( old('tags') ) )
                        @foreach (\App\Tag::find( old('tags') ) as $tag)
                            <option value="{{ $tag->id }}" selected="selected">
                                {{ $tag->text('name') }}
                            </option>
                        @endforeach
                    @elseif ( count( $designer->tags ) )
                        @foreach ($designer->tags as $tag)
                            <option value="{{ $tag->id }}" selected="selected">
                                {{ $tag->text('name') }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="input-email" class="col-sm-2 control-label">Email</label>
            <div class="col-sm-10 col-md-8">
                <input name="email" value="{{ old('email')===null?$designer->email:old('email') }}" type="email"
                    maxlength="255" class="form-control" id="input-email">
            </div>
        </div>

        <div class="form-group">
            <label for="input-website" class="col-sm-2 control-label">Website</label>
            <div class="col-sm-10 col-md-8">
                <input name="website" value="{{ old('website')===null?$designer->website:old('website') }}" type="url"
                    maxlength="255" class="form-control" id="input-website">
            </div>
        </div>

        <div class="form-group">
            <label for="input-facebook" class="col-sm-2 control-label">Facebook</label>
            <div class="col-sm-10 col-md-8">
                <input name="facebook" value="{{ old('facebook')===null?$designer->facebook:old('facebook') }}" type="url"
                    maxlength="255" class="form-control" id="input-facebook">
            </div>
        </div>

        <div class="form-group">
            <label for="input-twitter" class="col-sm-2 control-label">Twitter</label>
            <div class="col-sm-10 col-md-8">
                <input name="twitter" value="{{ old('twitter')===null?$designer->twitter:old('twitter') }}" type="url"
                    maxlength="255" class="form-control" id="input-twitter">
            </div>
        </div>

        <div class="form-group">
            <label for="input-google-plus" class="col-sm-2 control-label">Google+</label>
            <div class="col-sm-10 col-md-8">
                <input name="google_plus" value="{{ old('google_plus')===null?$designer->google_plus:old('google_plus') }}" type="url"
                    maxlength="255" class="form-control" id="input-google-plus">
            </div>
        </div>

        <div class="form-group">
            <label for="input-instagram" class="col-sm-2 control-label">Instagram</label>
            <div class="col-sm-10 col-md-8">
                <input name="instagram" value="{{ old('instagram')===null?$designer->instagram:old('instagram') }}" type="url"
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
