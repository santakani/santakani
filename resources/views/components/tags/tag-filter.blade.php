{{--

Usage:
    @include('components.tags.tag-filter', ['tags' => $tags, 'selected' => $tag])

Parameters:
    Collection<Tag> $tags       (optional)
    Tag             $selected   (optional)

--}}
<?php
if (!isset($tags)) {
    $tags = App\Tag::where('level', '255')->get();
}

if (empty($selected)) {
    $selected = null;
    if (request('tag_id')) {
        $selected = App\Tag::find(request('tag_id'));
    }
} elseif (is_int($selected) || is_string($selected)) {
    $selected = App\Tag::find($selected);
}
?>

<ul class="tag-filter list-inline {{ $class or '' }}">
    <li>
        @if (!empty($selected) && count($selected))
            <a href="{{ url()->current() }}?{{ http_build_query(request()->except('search', 'page', 'tag_id')) }}">{{ trans('common.all') }}</a>
        @else
            <strong>{{ trans('common.all') }}</strong>
        @endif
    </li>

    @foreach ($tags as $tag)
        <li>
            @if (!empty($selected) && count($selected) && $selected->id === $tag->id)
                <strong>{{ $tag->text('name') }}</strong>
            @else
                <a href="{{ url()->current() }}?tag_id={{ $tag->id }}&amp;{{ http_build_query(request()->except('search', 'page', 'tag_id')) }}">{{ $tag->text('name') }}</a>
            @endif
        </li>
    @endforeach
</ul>
