<div id="{{ $id or 'gallery-upload' }}" class="gallery-upload {{ $class or ''}}">
    <p>
        <button type="button" class="btn btn-default">{{ $button or 'Upload' }}</button>
        <input type="file" class="hidden" accept="image/*">
    </p>
    <div class="image-gallery clearfix">
        @foreach ($images as $image)
            <div class="image-preview" style="background-image:url({{$image->getThumbUrl()}})">
                <span><i class="fa fa-times"></i></span>
                <input type="hidden" name="{{ $name or 'images' }}[]" value="{{ $image_id or '' }}">
            </div>
        @endforeach
    </div>
    <p class="text-muted">Drag and drop to change the order of images.</p>
    <template>
        <div class="image-preview">
            <span><i class="fa fa-times"></i></span>
            <input type="hidden" name="{{ $name or 'images' }}[]">
        </div>
    </template>
</div>
