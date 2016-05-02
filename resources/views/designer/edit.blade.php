@extends('layout.edit', [
    'title' => 'Edit: ' . $designer->name,
    'body_id' => 'designer-edit-page',
    'body_class' => 'designer-edit-page',
    'back_link' => url('/designer/' . $designer->id),
])

@section('edit_content')
<form id="designer-edit-form" class="form-horizontal" action="{{ $designer->url }}">

    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <div class="alert alert-warning" style="display:none;" role="alert"></div>
        </div>
    </div>

    <div class="form-group">
        <label for="input-name" class="col-sm-2 control-label">
            Name</label>
        <div class="col-sm-10">
            <input name="name" type="text" class="form-control" id="input-name"
                value="{{ old('name')===null?$designer->text('name', 'en'):old('name') }}"
                placeholder="Name of designer or design brand"
                required>
        </div>
    </div>

    <div class="form-group">
        <label for="input-tagline" class="col-sm-2 control-label">Tagline</label>
        <div class="col-sm-10">
            <textarea name="tagline" class="form-control" id="input-tagline"
                placeholder="Express design philosophy in short"
                rows="2"  maxlength="255">{{
                old('tagline')===null?$designer->text('tagline', 'en'):old('tagline')
            }}</textarea>
            <p class="text-muted">Max. 255 characters.</p>
        </div>
    </div>

    <div class="form-group">
        <label for="input-content" class="col-sm-2 control-label">
            Story</label>
        <div class="col-sm-10">
            <textarea name="content" class="form-control tinymce" id="input-content"
                placeholder="Introduce your unique design story..." rows="5">{{
                old('content')===null?$designer->text('content', 'en'):old('content')
            }}</textarea>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">
            Main image</label>
        <div class="col-sm-10">
            @if ($image = App\Image::find($image_id = old('image')))
                @include('component.upload.image', [
                    'image_id' => $image_id,
                    'thumb_url' => $image->getThumbUrl(),
                ])
            @elseif ($designer->image)
                @include('component.upload.image', [
                    'image_id' => $designer->image_id,
                    'thumb_url' => $designer->image->getThumbUrl(),
                ])
            @else
                @include('component.upload.image')
            @endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">
            Image gallery</label>
        <div class="col-sm-10">
            @if (old('images')!==null)
                @include('component.upload.gallery', [
                    'images' => App\Image::find(old('images')),
                ])
            @elseif ($designer->images)
                @include('component.upload.gallery', [
                    'images' => $designer->images,
                ])
            @else
                @include('component.upload.gallery')
            @endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Location</label>
        <div class="col-sm-5 col-md-3">
            @include('component.input.country', [
                'class' => 'form-control',
                'selected' => old('country')===null?$designer->country_id:old('country')
            ])
        </div>
        <div class="col-sm-5 col-md-3">
            @include('component.input.city', [
                'class' => 'form-control',
                'selected' => old('city')===null?$designer->city_id:old('city')
            ])
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Tags</label>
        <div class="col-sm-10">
            @include('component.input.tag', [
                'class' => 'form-control',
                'selected' => old('tags')===null?$designer->tag_ids:old('tags')
            ])
        </div>
    </div>

    <div class="form-group">
        <label for="input-email" class="col-sm-2 control-label">Email</label>
        <div class="col-sm-10">
            <input name="email" value="{{ old('email')===null?$designer->email:old('email') }}" type="email"
                maxlength="255" class="form-control" id="input-email">
        </div>
    </div>

    <div class="form-group">
        <label for="input-facebook" class="col-sm-2 control-label">Facebook</label>
        <div class="col-sm-10">
            <input name="facebook" value="{{ old('facebook')===null?$designer->facebook:old('facebook') }}" type="url"
                maxlength="255" class="form-control" id="input-facebook">
        </div>
    </div>

    <div class="form-group">
        <label for="input-twitter" class="col-sm-2 control-label">Twitter</label>
        <div class="col-sm-10">
            <input name="twitter" value="{{ old('twitter')===null?$designer->twitter:old('twitter') }}" type="url"
                maxlength="255" class="form-control" id="input-twitter">
        </div>
    </div>

    <div class="form-group">
        <label for="input-google-plus" class="col-sm-2 control-label">Google+</label>
        <div class="col-sm-10">
            <input name="google_plus" value="{{ old('google_plus')===null?$designer->google_plus:old('google_plus') }}" type="url"
                maxlength="255" class="form-control" id="input-google-plus">
        </div>
    </div>

    <div class="form-group">
        <label for="input-instagram" class="col-sm-2 control-label">Instagram</label>
        <div class="col-sm-10">
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
@endsection
