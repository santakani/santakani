<button type="button" id="{{ $id or 'like-button' }}"
    class="{{ $class or '' }} like-button {{ $likeable->liked?'liked':'' }} btn btn-default"
    data-likeable-id="{{ $likeable->id}}" data-likeable-type="{{ snake_case(class_basename(get_class($likeable))) }}"
    data-liked="{{ $likeable->liked or false }}" data-like-count="{{ $likeable->like_count or 0 }}">
    <i class="liked-icon icon fa fa-lg fa-heart"></i>
    <i class="not-liked-icon icon fa fa-lg fa-heart-o"></i>
    <span class="like-text hidden-xs">{{ trans('common.like') }}</span>
    <span class="like-count">{{ $likeable->like_count or 0 }}</span>
</button>
