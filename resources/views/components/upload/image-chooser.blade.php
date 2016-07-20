<div id="{{ $id or '' }}" class="{{ $class or '' }} image-chooser"
     style="width:{{ $width or 150 }}px;height:{{ $height or 150 }}px"
     data-model="{{ empty($image)?'':$image->toJSON() }}" data-size="{{ $size or 'thumb' }}">
    <input type="hidden" name="{{ $name or 'image_id' }}"/>
    <button type="button"><i class="fa fa-camera"></i> {{ trans('image.choose_image') }}</button>
</div>
