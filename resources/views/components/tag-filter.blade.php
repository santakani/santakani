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

    <ul class="tag-list">
        <li class="{{ empty($selected) ? 'active' : '' }}" data-id="">
            <a href="#">{{ trans('common.all') }}</a>
        </li>

        @foreach ($tags as $tag)
            <li class="{{ $selected == $tag->id ? 'active' : '' }}" data-id="{{ $tag->id }}">
                <a href="#">{{ $tag->text('name') }}</a>
            </li>
        @endforeach
    </ul>
</div>
