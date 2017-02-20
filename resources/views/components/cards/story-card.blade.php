{{--

Usage:
    @include('components.cards.story-card', ['story' => $story])
or
    @each('components.cards.story-card', $stories, 'story')

Style:
    components/cards/_story-card.scss

Parameter:
    \App\Story story

--}}

<article id="story-{{ $story->id }}" class="story-card card clearfix">
    @if ($story->image_id)
        <a class="pull-left" href="{{ $story->url }}">
            <img class="card-cover" src="{{ $story->image->small_file_url }}" srcset="{{ $story->image->medium_file_url }} x2">
        </a>
    @endif
    <div class="card-body">
        <h3 class="card-title"><a href="{{ $story->url }}">{{ $story->text('title') }}</a></h3>
        <p>{{ $story->excerpt('content') }}</p>
    </div>
    <footer class="card-footer text-muted">
        <ul class="list-inline">
            <li>
                <a class="link-unstyled" href="{{ $story->user->url }}">
                    <img class="avatar" src="{{ $story->user->small_avatar_url }}" width="25" height="25">
                    {{ $story->user->name }}
                </a>
            </li>
            <li>{{ $story->created_at->formatLocalized(App\Localization\Languages::dateFormat()) }}</li>
            <li>{{ trans_choice('common.like_count', $story->like_count) }}</li>
        </ul>
    </footer>
</article>
