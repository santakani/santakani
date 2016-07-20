<select id="{{ $id or 'tag-select' }}" class="{{ $class or '' }} tag-select form-control"
        name="{{ $name or 'tag_ids' }}[]" multiple="multiple">
    @foreach ($selected as $tag)
        <option value="{{ $tag->id }}" data-data="{{ $tag->toJSON() }}" selected="selected">{{ $tag->name }}</option>
    @endforeach
    @foreach (App\Tag::orderBy('level', 'desc')->take(100)->get() as $tag)
        @if (!$selected->contains('id', $tag->id))
            <option value="{{ $tag->id }}" data-data="{{ $tag->toJSON() }}">{{ $tag->name }}</option>
        @endif
    @endforeach
</select>
