<ul class="{{ $class or '' }} tag-list">
    @foreach ($tags as $tag)
        <li><a href="{{ url('tag/' . $tag->id) }}">{{ $tag->text('name') }}</a></li>
    @endforeach
</ul>
