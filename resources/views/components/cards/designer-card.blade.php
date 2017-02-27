{{--

Usage:
    @include('components.cards.designer-card', ['designer' => $designer])
or
    @each('components.cards.designer-card', $designers, 'designer')

Style:
    components/_card.scss

Parameter:
    \App\Story  $designer   (required)
    string      $class      (optional)

--}}

<article id="designer-{{ $designer->id }}" class="designer-card card clearfix {{ $class or '' }}">
    <a class="card-cover-wrap" href="{{ $designer->url }}">
        @if ($designer->image_id)
            <img class="card-cover" src="{{ $designer->image->banner_file_url }}" srcset="{{ $designer->image->largebanner_file_url }} x2">
        @else
            <!-- Fallback cover -->
            <img class="card-cover" src="{{ url('img/placeholder/banner.svg') }}">
        @endif

        @if ($designer->logo_id)
            <img class="card-logo" src="{{ $designer->logo->thumb_file_url }}" width="50" height="50">
        @else
            <!-- Fallback logo -->
            <img class="card-logo" src="{{ url('img/placeholder/thumb.svg') }}" width="50" height="50">
        @endif
    </a>

    <div class="card-body">
        <h3 class="card-title"><a href="{{ $designer->url }}">{{ $designer->text('name') }}</a></h3>
        <div class="card-description">{{ $designer->text('tagline') }}</div>
    </div>
    <footer class="card-footer text-muted">
        <ul class="list-inline">
            @if ($designer->city_id)
                <li>{{ $designer->city->full_name }}</li>
            @endif
            <li>{{ trans_choice('design.design_count', $designer->designs->count()) }}</li>
            <li>{{ trans_choice('common.like_count', $designer->like_count) }}</li>
        </ul>
    </footer>
</article>
