{{--

Usage:
    @include('components.cards.place-card', ['place' => $place])
or
    @each('components.cards.place-card', $places, 'place')

Style:
    components/_card.scss

Parameter:
    \App\Place  $place      (required)
    string      $class      (optional)
    boolean     $hide_city  (optional)
    boolean     $with_data  (optional)

--}}

<article id="place-{{ $place->id }}" class="place-card card clearfix {{ $class or '' }}" data-model="{{ empty($with_data) ? '' : $place }}">
    <a class="card-cover-wrap" href="{{ $place->url }}">
        @if ($place->image_id)
            <img class="card-cover" src="{{ $place->image->banner_file_url }}" srcset="{{ $place->image->largebanner_file_url }} x2" width="600" height="300">
        @else
            <!-- Fallback cover -->
            <img class="card-cover" src="{{ url('img/placeholder/banner.svg') }}" width="600" height="300">
        @endif

        @if ($place->logo_id)
            <img class="card-logo" src="{{ $place->image->thumb_file_url }}" width="50" height="50">
        @endif
    </a>

    <div class="card-body">
        <h3 class="card-title text-nowrap"><a class="link-unstyled" href="{{ $place->url }}">{{ $place->text('name') }}</a></h3>
        <div class="card-description text-nowrap">
            @include('components.tags.tags-hash', ['tags' => $place->tags])
        </div>
    </div>
    <footer class="card-footer text-muted">
        <ul class="list-inline">
            <li>{{ $place->address }}</li>
            @if ($place->city_id && empty($hide_city))
                <li>{{ $place->city->full_name }}</li>
            @endif
            <li>{{ trans_choice('common.like_count', $place->like_count) }}</li>
        </ul>
    </footer>
</article>
