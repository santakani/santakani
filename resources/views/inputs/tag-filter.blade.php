<?php
if (!isset($tags)) {
    $tags = App\Tag::where('level', '>', '199')->get();
}

if (!isset($selected)) {
    $selected = null;
}
?>

<div class="tag-filter">
    <input type="hidden" name="{{ $name or 'tag_id' }}" value="{{ $selected }}">

    <a class="{{ empty($selected) ? 'active' : '' }}" data-id="" href="#">{{ trans('common.all') }}</a>

    @foreach ($tags as $tag)
        <a class="{{ $selected == $tag->id ? 'active' : '' }}" data-id="{{ $tag->id }}" href="#">{{ $tag->text('name') }}</a>
    @endforeach
</div>
