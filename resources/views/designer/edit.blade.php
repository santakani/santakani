@extends('layout.edit', [
    'title' => 'Edit: ' . $designer->name,
    'body_id' => 'designer-edit-page',
    'body_class' => 'designer-edit-page',
    'back_link' => url('/designer/' . $designer->id),
])

@section('edit_content')
<form class="form-horizontal" action="{{ $designer->url }}">

    <div class="form-group">
        <label for="input-name" class="col-sm-2 control-label">
            Name</label>
        <div class="col-sm-10">
            <input name="name" type="text" class="form-control" id="input-name"
                placeholder="Name of designer or design brand"
                value="{{ old('name')===null?$designer->text('name', 'en'):old('name') }}">
        </div>
    </div>

    <div class="form-group">
        <label for="input-tagline" class="col-sm-2 control-label">Tagline</label>
        <div class="col-sm-10">
            <textarea name="tagline" rows="2" required maxlength="255" class="form-control" id="input-tagline"
                placeholder="Express design philosophy in short">{{ old('tagline')===null?$designer->text('tagline', 'en'):old('tagline') }}</textarea>
            <p class="text-muted">Max. 255 characters.</p>
        </div>
    </div>

    <div class="form-group">
        <label for="input-content" class="col-sm-2 control-label">
            Story</label>
        <div class="col-sm-10">
            <textarea name="content" class="form-control" id="input-content" rows="5"
                placeholder="Introduce your unique design story...">{{ old('content')===null?$designer->text('content', 'en'):old('content') }}</textarea>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">
            Main image</label>
        <div class="col-sm-10">
            @if ($image = App\Image::find($image_id = old('image')))
                @include('component.input.imageupload', [
                    'image_id' => $image_id,
                    'thumb_url' => $image->getThumbUrl(),
                ])
            @elseif ($designer->image)
                @include('component.input.imageupload', [
                    'image_id' => $designer->image_id,
                    'thumb_url' => $designer->image->getThumbUrl(),
                ])
            @else
                @include('component.input.imageupload')
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
        <div class="col-sm-10 col-md-8">
            @include('component.input.tag', [
                'class' => 'form-control',
                'selected' => old('tags')===null?$designer->tag_ids:old('tags')
            ])
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">Save</button>
        </div>
    </div>

</form>
@endsection
