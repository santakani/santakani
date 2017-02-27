{{--

Usage:
    @include('components.cards.design-card', ['design' => $design])
or
    @each('components.cards.design-card', $designs, 'design')

Style:
    components/_card.scss

Parameter:
    \App\Design $design         (required)
    string      $class          (optional)
    boolean     $hide_designer  (optional)

--}}

<article id="design-{{ $design->id }}" class="design-card card clearfix {{ $class or '' }}">
    <a class="card-cover-wrap" href="{{ $design->url }}">
        @if ($design->image_id)
            <img class="card-cover" src="{{ $design->image->thumb_file_url }}" srcset="{{ $design->image->largethumb_file_url }} x2" width="300" height="300">
        @else
            <!-- Fallback cover -->
            <img class="card-cover" src="https://source.unsplash.com/category/nature/300x300" srcset="https://source.unsplash.com/category/nature/600x600 x2" width="300" height="300">
        @endif
        <span class="price label label-info">
            {{ $design->price }} {{ $design->currency }}
        </span>
    </a>

    <div class="card-body">
        <h3 class="card-title">
            <a class="link-unstyled" href="{{ $design->url }}">
                {{ $design->text('name') }}
            </a>
        </h3>
    </div>
    <footer class="card-footer text-muted">
        <ul class="list-inline">
            @if ($design->designer_id && empty($hide_designer))
                <li>
                    <a class="link-unstyled" href="{{ $design->designer->url }}">
                        @if ($design->designer->logo_id)
                            <img src="{{ $design->designer->logo->thumb_file_url }}" width="24" height="24">
                        @else
                            <img src="{{ url('img/placeholder/thumb.svg') }}" width="24" height="24">
                        @endif
                        {{ $design->designer->text('name') }}
                    </a>
                </li>
            @endif
            <li>{{ trans_choice('common.like_count', $design->like_count) }}</li>
        </ul>
    </footer>
</article>
