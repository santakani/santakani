@extends('layout.app', [
    'title' => 'Edit: ' . $designer->name,
    'body_id' => 'designer-edit-page',
    'body_class' => 'designer-edit edit',
])

@section('main')
<div class="container">
<form id="designer-edit-form" class="form-horizontal" action="{{ $designer->url }}">

    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10 col-md-8">
            <div class="alert alert-warning" style="display:none;" role="alert"></div>
        </div>
    </div>

    <div class="form-group">
        <label for="input-name" class="col-sm-2 control-label">
            Name</label>
        <div class="col-sm-10 col-md-8">
            <input name="name" type="text" class="form-control" id="input-name"
                value="{{ old('name')===null?$designer->text('name', 'en'):old('name') }}"
                placeholder="Name of designer or design brand"
                required>
        </div>
    </div>

    <div id="image-form-group" class="form-group">
        <label class="col-sm-2 control-label">
            Cover image</label>
        <div class="col-sm-10 col-md-8">
            @include('component.upload.imageuploader')
            <br>
            @if ($image = App\Image::find($image_id = old('image')))
                @include('component.upload.imagepreview', ['id' => $image_id, 'url' => $image->file_urls['medium'], 'remove' => false])
            @elseif ($designer->image)
                @include('component.upload.imagepreview', ['id' => $designer->image_id, 'url' => $designer->image->file_urls['medium'], 'remove' => false])
            @else
                @include('component.upload.imagepreview', ['remove' => false])
            @endif
        </div>
    </div>

    <div class="form-group">
        <label for="input-tagline" class="col-sm-2 control-label">Tagline</label>
        <div class="col-sm-10 col-md-8">
            <input type="text" name="tagline" class="form-control" id="input-tagline"
                placeholder="Express design philosophy in short" maxlength="255"
                value="{{old('tagline')===null?$designer->text('tagline', 'en'):old('tagline')}}">
        </div>
    </div>

    <div class="form-group">
        <label for="input-content" class="col-sm-2 control-label">
            Story</label>
        <div class="col-sm-10 col-md-8">
            <textarea name="content" class="form-control tinymce" id="input-content"
                placeholder="Introduce your unique design story..." rows="5">{{
                old('content')===null?$designer->text('content', 'en'):old('content')
            }}</textarea>
        </div>
    </div>

    <div id="gallery-form-group" class="form-group">
        <label class="col-sm-2 control-label">
            Image gallery</label>
        <div class="col-sm-10 col-md-8">
            @include('component.upload.imageuploader')
            <br>
            <div class="image-gallery">
                @if (old('images')!==null)
                    @foreach (App\Image::find(old('images')) as $image)
                        @include('component.upload.imagepreview', [
                            'name' => 'images[]',
                            'id' => $image->id,
                            'url' => $image->file_urls['thumb'],
                            'remove' => true,
                        ])
                    @endforeach
                @elseif ($designer->images)
                    @foreach ($designer->images as $image)
                        @include('component.upload.imagepreview', [
                            'name' => 'images[]',
                            'id' => $image->id,
                            'url' => $image->file_urls['thumb'],
                            'remove' => true,
                        ])
                    @endforeach
                @endif
            </div>
            <template>
                @include('component.upload.imagepreview', [
                    'name' => 'images[]',
                    'remove' => true,
                ])
            </template>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Location</label>
        <div class="col-sm-5 col-md-4">
            @include('component.input.country', [
                'class' => 'form-control',
                'selected' => old('country')===null?$designer->country_id:old('country')
            ])
        </div>
        <div class="col-sm-5 col-md-4">
            @include('component.input.city', [
                'class' => 'form-control',
                'selected' => old('city')===null?$designer->city_id:old('city')
            ])
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Tags</label>
        <div class="col-sm-10 col-md-8">
            @include('component.input.tag', [
                'class' => 'form-control',
                'selected' => old('tags')===null?$designer->tag_ids:old('tags')
            ])
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
