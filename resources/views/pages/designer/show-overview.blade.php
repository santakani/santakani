{{--

Overview tab

--}}

<h2>{{ trans('design.designs') }}</h2>

<div id="overview-designs" class="row">
    @foreach ($designs as $design)
        <div class="col-sm-6 col-md-4 col-lg-3 {{ $loop->index >= 4 ? 'visible-md-block' : ''}}">
            @include('components.cards.design-card', ['design' => $design, 'hide_designer' => true])
        </div>
    @endforeach
</div>

<div class="text-right">
    @if (Auth::check() && Auth::user()->can('edit-designer', $designer))
        <a class="btn btn-link" href="{{ url('design/create?designer_id='.$designer->id) }}">
            {{ trans('design.create_design') }}
        </a>
    @endif
    <a class="btn btn-link" href="{{ $designer->url }}?tab=designs">
        {{ trans('common.more') }}...
    </a>
</div>


<h2>{{ trans('common.images') }}</h2>

<div id="overview-images" class="images row">
    @foreach ($images as $image)
        <div class="col-sm-6 col-md-4 col-lg-3 {{ $loop->index >= 4 ? 'visible-md-block' : ''}}">
            <a href="{{ $image->large_file_url }}">
                <img src="{{ $image->thumb_file_url }}" srcset="{{ $image->largethumb_file_url }} x2" width="300" height="300">
            </a>
        </div>
    @endforeach
</div>

<div class="text-right">
    @if (Auth::check() && Auth::user()->can('edit-designer', $designer))
        <a class="btn btn-link" href="{{ $designer->url }}/edit#images">
            {{ trans('image.upload_image') }}
        </a>
    @endif
    <a class="btn btn-link" href="{{ $designer->url }}?tab=images">
        {{ trans('common.more') }}...
    </a>
</div>


<div id="overview-description">
    <h2>{{ trans('common.description') }}</h2>
    <p>
        {{ $designer->excerpt('content', null, 400) }}
        <a href="{{ $designer->url }}?tab=description">[{{ mb_strtolower(trans('common.more')) }}]</a>
    </p>
</div>


<div id="overview-likes">
    <p class="text-muted">{{ trans_choice('common.like_count', $designer->likes()->count()) }}</p>
    <p>
        @foreach ($likes as $like)
            <span class="like">
                <a class="link-unstyled" href="{{ $like->user->url }}">
                    <img src="{{ $like->user->avatar('small') }}" srcset="{{ $like->user->avatar('medium') }} x3" width="50" height="50">
                    {{ $like->user->name }}
                </a>
            </span>
        @endforeach
    </p>
</div>

<ul id="social-links" class="social-links list-unstyled">
    @if ($designer->facebook)
        <li>
            <a class="link-unstyled text-nowrap" href="{{ $designer->facebook }}" target="_blank">
                <span class="icon ion-social-facebook"></span>
                Facebook
            </a>
        </li>
    @endif
    @if ($designer->twitter)
        <li>
            <a class="link-unstyled text-nowrap" href="{{ $designer->twitter }}" target="_blank">
                <span class="icon ion-social-twitter"></span>
                Twitter
            </a>
        </li>
    @endif
    @if ($designer->instagram)
        <li>
            <a class="link-unstyled text-nowrap" href="{{ $designer->instagram }}" target="_blank">
                <span class="icon ion-social-instagram"></span>
                Instagram
            </a>
        </li>
    @endif
    @if ($designer->pinterest)
        <li>
            <a class="link-unstyled text-nowrap" href="{{ $designer->pinterest }}" target="_blank">
                <span class="icon ion-social-pinterest"></span>
                Pinterest
            </a>
        </li>
    @endif
    @if ($designer->vimeo)
        <li>
            <a class="link-unstyled text-nowrap" href="{{ $designer->vimeo }}" target="_blank">
                <span class="icon ion-social-vimeo"></span>
                Vimeo
            </a>
        </li>
    @endif
    @if ($designer->youtube)
        <li>
            <a class="link-unstyled text-nowrap" href="{{ $designer->youtube }}" target="_blank">
                <span class="icon ion-social-youtube"></span>
                YouTube
            </a>
        </li>
    @endif
    @if ($designer->website)
        <li>
            <a class="link-unstyled text-nowrap" href="{{ $designer->website }}" target="_blank">
                <span class="icon ion-earth"></span>
                Website
            </a>
        </li>
    @endif
    @if ($designer->email)
        <li>
            <a class="link-unstyled text-nowrap" href="mailto:{{ $designer->email }}">
                <span class="icon ion-at"></span>
                Email
            </a>
        </li>
    @endif
</ul>

@include('components.tags.tags-hash', ['tags' => $designer->tags, 'linked' => true])
