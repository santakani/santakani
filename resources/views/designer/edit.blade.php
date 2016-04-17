@extends('layout.edit', [
    'title' => 'Edit: ' . $designer->getTranslation()->name,
    'body_id' => 'designer-edit-page',
    'body_class' => 'designer-edit-page',
    'back_link' => url('/designer/' . $designer->id),
])

@section('edit_content')
<form class="form-horizontal" action="{{ url('designer/'.$designer->id) }}"
    method="put">

    <div class="form-group">
        <label for="input-name" class="col-sm-2 control-label">
            Name</label>
        <div class="col-sm-10">
            <input name="name" type="text" class="form-control" id="input-name"
                placeholder="Name of designer or design brand"
                value="{{ $designer->getTranslation()->name }}">
        </div>
    </div>

    <div class="form-group">
        <label for="input-content" class="col-sm-2 control-label">
            Story</label>
        <div class="col-sm-10">
            <textarea name="content" class="form-control" id="input-content" rows="5"
                placeholder="Introduce your unique design story...">{{ $designer->getTranslation()->content }}</textarea>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">
            Main image</label>
        <div class="col-sm-10">
            <p>
                <button type="button" id="button-main-image" class="btn btn-default">Change</button>
                <input type="file" id="input-main-image" class="hidden" accept="image/*">
            </p>
            <div id="main-image-preview" class="image-preview"
                style="background-image:url({{$designer->getMainImage()->getThumbUrl()}})"
                data-image-id="{{$designer->getMainImage()->id}}"></div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">
            Image gallery</label>
        <div class="col-sm-10">
            <p>
                <button type="button" id="button-upload-image" class="btn btn-default">Upload</button>
                <input type="file" id="input-upload-image" class="hidden" accept="image/*">
            </p>
            <div id="image-gallery" class="clearfix">
            @foreach ($designer->getImages() as $image)
                <div class="image-preview" data-image-id="{{$designer->getMainImage()->id}}"
                    style="background-image:url({{$image->getThumbUrl()}})">
                    <span><i class="fa fa-times"></i></span>
                </div>
            @endforeach
            </div>
            <p class="text-muted">Drag and drop to change the order of images.</p>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Location</label>
        <div class="col-sm-5 col-md-3">
            @include('component.input.country', ['class' => 'form-control', 'selected' => $designer->country_id])
        </div>
        <div class="col-sm-5 col-md-3">
            @include('component.input.city', ['class' => 'form-control', 'selected' => $designer->city_id])
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">Save</button>
        </div>
    </div>

</form>
@endsection
