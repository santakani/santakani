<div id="gallery-editor" class="gallery-editor">
    <p><button type="button" class="btn btn-default"><i class="fa fa-picture-o"></i> {{ trans('image.choose_image') }}</button></p>
    <div class="images clearfix">
        @foreach ($images as $image)
            @include('components.upload.image-preview', ['image' => $image])
        @endforeach
    </div>
</div>
