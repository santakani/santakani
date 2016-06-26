<button type="button" id="{{ $id or 'like-button' }}"
    class="{{ $class or '' }} like-button {{ $likeable->liked?'liked':'' }} btn btn-default"
    data-likeable-id="{{ $likeable->id}}" data-likeable-type="{{ snake_case(class_basename(get_class($likeable))) }}"
    data-liked="{{ $likeable->liked }}">
    <i class="liked-icon icon fa fa-heart"></i>
    <i class="not-liked-icon icon fa fa-heart-o"></i>
    {{ trans('common.like') }}
    <span class="badge">{{ $likeable->like_count }}</span>
</button>
