<select name="{{ $name or 'tags' }}" id="{{ $id or 'tag-select' }}"
    class="{{ $class or '' }}" multiple>
    @foreach (App\Tag::all() as $tag)
        @if (isset($selected) && in_array($tag->id, $selected))
            <option value="{{ $tag->id }}" selected>{{ $tag->getTranslation()->name }}</option>
        @else
            <option value="{{ $tag->id }}">{{ $tag->getTranslation()->name }}</option>
        @endif
    @endforeach
</select>
