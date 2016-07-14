<p>{{ trans('geo.coordinate_select_help') }}</p>

<div id="{{ $id or 'coordinate-select' }}" class="{{ $class or '' }} coordinate-select">
    <input type="hidden" name="latitude" value="{{ $latitude or '' }}">
    <input type="hidden" name="longitude" value="{{ $longitude or '' }}">

    <div class="map"></div>

    <div class="map-pin"></div>

    <div class="alerts">
        <div class="alert alert-success" style="display:none">{{ trans('geo.coordinate_select_found_alert') }}</div>
        <div class="alert alert-warning" style="display:none">{{ trans('geo.coordinate_select_not_found_alert') }}</div>
    </div>

    <ul class="coordiate list-inline">
        <li>
            <button class="btn btn-default lookup-button" type="button">
                <i class="fa fa-search"></i> {{ trans('geo.smart_lookup') }}
            </button>
        </li>
        <li>{{ trans('geo.latitude') }} <span class="latitude">{{ $latitude or '' }}</span></li>
        <li>{{ trans('geo.longitude') }} <span class="longitude">{{ $longitude or '' }}</span></li>
    </ul>
</div>
