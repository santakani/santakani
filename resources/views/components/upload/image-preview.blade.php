@if (isset($image))
<div class="image-preview" data-id="{{ $image->id }}" data-width="{{ $image->width }}"
    data-height="{{ $image->height }}" data-mime="{{ $image->mime_type }}"
    data-model="{{ $image->toJSON() }}"
    style="background-image:url({{ $image->fileUrl('thumb') }})">
</div>
@else
<div class="image-preview"></div>
@endif
