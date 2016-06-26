<?php
if (!isset($tags)) {
    $tags = App\Tag::all();
}
if (!isset($selected)) {
    $selected = 0;
}
?>

<div class="tag-filter" data-toggle="buttons">
    <label class="btn btn-default {{ $selected == 0 ? 'active' : '' }}">
        <input type="radio" name="{{ $name or 'tag_id' }}" value="" checked="{{ $selected == 0 ? 'checked' : '' }}" />
        {{ mb_strtolower(trans('common.all')) }}
    </label>

    @foreach ($tags as $tag)
        <label class="btn btn-default {{ $selected == $tag->id ? 'active' : '' }}">
            <input type="radio" name="{{ $name or 'tag_id' }}" value="{{ $tag->id }}" checked="{{ $selected == $tag->id ? 'checked' : '' }}" />
            {{ $tag->text('name') }}
        </label>
    @endforeach
</div>
