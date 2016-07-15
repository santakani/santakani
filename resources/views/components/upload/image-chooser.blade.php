<div id="{{ $id or '' }}" class="{{ $class or '' }} image-chooser"
     data-model="{{ empty($image)?'':$image->toJSON() }}">
    <input type="hidden" name="{{ $name or 'image_id' }}"/>
    <button type="button"><i class="fa fa-camera"></i> {{ trans('image.choose_image') }}</button>
</div>
