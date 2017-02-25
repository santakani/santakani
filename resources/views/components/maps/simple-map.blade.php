{{--

Simple map for a place without interaction, linked to Google Maps

Useage:
    @include('components.maps.simple-map', ['place' => $place])

--}}

 <div class="simple-map" data-model="{{ $place }}" title="{{ trans('geo.open_google_maps') }}">
    <div class="map"></div>
    <div class="info text-center">
        <a class="btn btn-info" href="{{ $place->google_maps_url }}">
            {{ trans('geo.open_google_maps') }}
        </a>
    </div>
</div>
