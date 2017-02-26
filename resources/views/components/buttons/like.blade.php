<button type="button" id="{{ $id or 'like-button' }}"
    class="{{ $class or 'btn-icon' }} like-button {{ $likeable->liked?'liked':'' }}"
    data-likeable-id="{{ $likeable->id}}"
    data-likeable-type="{{ snake_case(class_basename(get_class($likeable))) }}"
    data-liked="{{ $likeable->liked or false }}"
    data-like-count="{{ $likeable->like_count or 0 }}"
    title="{{ trans('common.like') }}">
    <span class="liked-icon icon ion-ios-heart"></span>
    <span class="not-liked-icon icon ion-ios-heart-outline"></span>
    @if (!empty($has_text))
        <span class="text">{{ trans('common.like') }}</span>
    @endif
</button>
