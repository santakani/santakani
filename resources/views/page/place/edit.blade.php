@extends('layout.app', [
    'title' => 'Edit: ' . $place->name,
    'body_id' => 'place-edit-page',
    'body_class' => 'place-edit-page place-page edit-page',
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
                    name="name" value="{{ old('name')?old('name'):$place->text('name', 'en') }}"
                    placeholder="Name of place" maxlength="255">
            </div>
        </div>

        <div class="form-group">
            <label for="place-type-select" class="col-sm-2 control-label">
                Type
            </label>

            <div class="col-sm-4 col-md-3">
                <?php $selected = old('type') ? old('type') : $place->type; ?>
                @include('component.place-type-select', [
                    'selected' => $selected,
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
                    @if ($image = App\Image::find(old('image')))
                        @include('component.image-preview', ['image' => $image])
                    @elseif ($place->image_id)
                        @include('component.image-preview', ['image' => $place->image])
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
                        @if ( count( old('gallery_image_ids') ) )
                            @foreach (\App\Image::find( old('gallery_image_ids') ) as $image)
                                @include('component.image-preview', ['image' => $image])
                            @endforeach
                        @elseif ( count( $place->gallery_images ) )
                            @foreach ($place->gallery_images as $image)
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
                } elseif ($place->city_id) {
                    $city = $place->city;
                }

                if (!empty($city)) {
                    $country = $city->country;
                }
            ?>

            <label class="col-sm-2 control-label">
                Country
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
            <label for="address-input" class="col-sm-2 control-label">
                Address
            </label>

            <div class="col-sm-10 col-md-8">
                <input id="address-input" class="form-control" type="text"
                    name="address" value="{{ old('address')?old('address'):$place->address }}"
                    maxlength="255">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">
                Coordinates
            </label>
            <div class="col-sm-10 col-md-8">
                @include('component.coordinate-select', [
                    'latitude' => old('latitude') ? old('latitude') : $place->latitude,
                    'longitude' => old('longitude') ? old('longitude') : $place->longitude,
                ])
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
                    @elseif ( count( $place->tags ) )
                        @foreach ($place->tags as $tag)
                            <option value="{{ $tag->id }}" selected="selected">
                                {{ $tag->text('name') }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="phone-input" class="col-sm-2 control-label">
                Phone
            </label>
            <div class="col-sm-10 col-md-8">
                <input id="phone-input" class="form-control" type="tel"
                       name="phone" value="{{ old('phone') ? old('phone') : $place->phone }}"
                       maxlength="255">
            </div>
        </div>

        <div class="form-group">
            <label for="input-email" class="col-sm-2 control-label">Email</label>
            <div class="col-sm-10 col-md-8">
                <input name="email" value="{{ old('email')===null?$place->email:old('email') }}" type="email"
                    maxlength="255" class="form-control" id="input-email">
            </div>
        </div>

        <div class="form-group">
            <label for="input-website" class="col-sm-2 control-label">Website</label>
            <div class="col-sm-10 col-md-8">
                <input name="website" value="{{ old('website')===null?$place->website:old('website') }}" type="url"
                    maxlength="255" class="form-control" id="input-website">
            </div>
        </div>

        <div class="form-group">
            <label for="input-facebook" class="col-sm-2 control-label">Facebook</label>
            <div class="col-sm-10 col-md-8">
                <input name="facebook" value="{{ old('facebook')===null?$place->facebook:old('facebook') }}" type="url"
                    maxlength="255" class="form-control" id="input-facebook">
            </div>
        </div>

        <div class="form-group">
            <label for="input-google-plus" class="col-sm-2 control-label">Google+</label>
            <div class="col-sm-10 col-md-8">
                <input name="google_plus" value="{{ old('google_plus')===null?$place->google_plus:old('google_plus') }}" type="url"
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
    @include('component.image-manager')
@endpush
