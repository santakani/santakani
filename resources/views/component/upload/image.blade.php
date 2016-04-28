<div id="{{ $id or 'image-upload' }}" class="image-upload {{ $class or ''}}">
    <p>
        <button type="button" class="btn btn-default">Change</button>
        <input type="file" class="hidden" accept="image/*">
        <input type="number" class="hidden" name="{{ $name or 'image' }}" value="{{ $image_id or '' }}">
    </p>
    <div class="image-preview" style="background-image:url({{ $thumb_url or '' }})"></div>
</div>
