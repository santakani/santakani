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
    <a class="btn btn-link" href="{{ url('design/create?designer_id='.$designer->id) }}">
        {{ trans('common.create') }}
    </a>
    <a class="btn btn-link" href="{{ $designer->url }}?tab=designs">
        {{ trans('common.more') }}...
    </a>
</div>

<h2>{{ trans('common.images') }}</h2>

<div id="overview-images" class="row">
    @foreach ($images as $image)
        <div class="col-sm-6 col-md-4 col-lg-3 {{ $loop->index >= 4 ? 'visible-md-block' : ''}}">
            <a href="{{ $image->large_file_url }}">
                <img src="{{ $image->thumb_file_url }}" srcset="{{ $image->largethumb_file_url }} x2" width="300" height="300">
            </a>
        </div>
    @endforeach
</div>

<div class="text-right">
    <a class="btn btn-link" href="{{ $designer->url }}/edit#images">
        {{ trans('common.upload') }}
    </a>
    <a class="btn btn-link" href="{{ $designer->url }}?tab=images">
        {{ trans('common.more') }}...
    </a>
</div>

<h2>{{ trans_choice('common.like_noun', 10) }}</h2>

<div id="overview-likes" class="row">
    @foreach ($likes as $like)
        <div class="col-xs-4 col-sm-3 col-md-2 {{ $loop->index >= 4 ? 'visible-md-block' : ''}}">
            <a href="{{ $like->user->url }}" title="{{ $like->user->name }}">
                <img class="img-circle img-responsive" src="{{ $like->user->avatar('medium') }}" srcset="{{ $like->user->avatar('large') }} x2" width="150" height="150">
            </a>
        </div>
    @endforeach
</div>

<div class="text-right">
    <a class="btn btn-link" href="{{ $designer->url }}?tab=likes">
        {{ trans('common.more') }}...
    </a>
</div>
