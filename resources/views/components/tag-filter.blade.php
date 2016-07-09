<?php
if (!isset($tags)) {
    $tags = App\Tag::where('level', '>', '199')->get();
}

if (!isset($selected)) {
    $selected = null;
}
?>

<div class="tag-filter" data-toggle="buttons">
    <input type="hidden" name="{{ $name or 'tag_id' }}" value="{{ $selected }}">

    <button type="button" class="btn btn-default {{ empty($selected) ? 'active' : '' }}" data-id="">
        {{ mb_strtolower(trans('common.all')) }}
    </button>

    @foreach ($tags as $tag)
        <button type="button" class="btn btn-default {{ intval($selected) === $tag->id ? 'active' : '' }}" data-id="{{ $tag->id }}">
            {{ mb_strtolower($tag->text('name')) }}
        </button>
    @endforeach
</div>
