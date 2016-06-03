@if (isset($image))
<div class="image-preview" data-id="{{ $image->id }}" data-width="{{ $image->width }}"
    data-height="{{ $image->height }}" data-mime="{{ $image->mime_type }}"
    style="background-image:url({{ $image->file_urls['thumb'] }})">
</div>
@else
<div class="image-preview"></div>
@endif
