<button type="button" id="{{ $id or 'like-button' }}"
    class="{{ $class or '' }} like-button {{ $likeable->liked?'liked':'' }} btn btn-default"
    data-likeable-id="{{ $likeable->id}}" data-likeable-type="{{ snake_case(class_basename(get_class($likeable))) }}"
    data-liked="{{ $likeable->liked }}" data-like-count="{{ $likeable->like_count }}">
    <i class="liked-icon icon fa fa-heart"></i>
    <i class="not-liked-icon icon fa fa-heart-o"></i>
    <span class="hidden-xs">{{ trans('common.like') }}</span>
    <span class="like-count badge">{{ $likeable->like_count }}</span>
</button>
