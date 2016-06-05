<ul class="tag-list-{{ $style or 'plain' }} tag-list list-inline">
    @foreach ($tags as $tag)
        <li><a href="{{ url('tag/' . $tag->id) }}">{{ $tag->text('name') }}</a></li>
    @endforeach
</ul>
