@extends('layout.app')

@section('content')
<div id="place-wrapper" class="clearfix">
    <div id="place-map" data-spy="affix" data-offset-top="300">
        <div id="place-map-inner"></div>
    </div>
    <div id="place-list">
        <div class="grid row">
            @foreach ($places as $place)
                <article id="place-{{ $place->id }}" class="place grid-item col-xs-12 col-sm-6 col-md-4 col-lg-3">
                    <img class="featured-image" src="{{ $designer->getImage()->getThumbUrl() }}" />
                    <h3 class="title"><a href="{{ url('/designer/' . $designer->id) }}">
                        {{ $designer->getTranslation()->name }}</a></h3>
                    <div class="content">{!! $designer->getTranslation()->content !!}</div>
                    <div class="expand-button btn btn-sm btn-default">
                        <span class="more"><i class="fa fa-angle-down"></i> More</span>
                        <span class="less"><i class="fa fa-angle-up"></i> Less</span>
                    </div>
                </article>
            @endforeach
        </div><!-- .grid.row -->
    </div><!-- #place-list.container -->
</div>
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API_KEY') }}&callback=initMap"></script>
@endsection
