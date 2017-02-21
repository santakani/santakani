{{--

Usage:
    @include('components.tags.hashtags', ['tags' => $tags])

Style:
    components/_tags.scss

Parameter:
    Collection<Tag> $tags   (required)
    string          $class  (optional)
    boolean         $linked (optional)

--}}

<ul class="tags tags-hash list-inline text-lowercase">
    @foreach ($tags as $tag)
        <li>
            @if (empty($linked))
                #{{ $tag->text('name') }}
            @else
                <a href="{{ $tag->url }}">#{{ $tag->text('name') }}</a>
            @endif
        </li>
    @endforeach
</ul>
