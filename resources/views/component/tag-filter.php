<?php
if (!isset($tags)) {
    $tags = App\Tag::all();
}
?>
@foreach ($tags as $tag)
<label class="btn btn-default">
    <input type="radio" name="tag" value="{{ $tag->id }}"
        checked="{{ $selected == $tag->id ? 'checked' : '' }}" />
    {{ $tag->text('name') }}
</label>
@endforeach
