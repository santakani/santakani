<div id="{{ $id or 'coordinate-select' }}" class="{{ $class or '' }} coordinate-select">
    <input type="hidden" name="latitude" value="{{ $latitude or '' }}">
    <input type="hidden" name="longitude" value="{{ $longitude or '' }}">

    <div class="map"></div>

    <div class="map-pin"></div>

    <div class="locker">
        <p><i class="fa fa-2x fa-lock"></i></p>
        <p>{{ trans('geo.coordinate_select_locked_tooltip') }}</p>
    </div>

    <div class="buttons">
        <button class="btn btn-success close-button" type="button">
            <i class="fa fa-check"></i> {{ trans('common.ok') }}
        </button>
        <button class="btn btn-default lookup-button" type="button">
            <i class="fa fa-search"></i> {{ trans('geo.smart_lookup') }}
        </button>
        <button class="btn btn-default manual-button" type="button">
            <i class="fa fa-hand-paper-o"></i> {{ trans('geo.mark_by_hand') }}</button>
    </div>

    <ul class="coordiate list-inline">
        <li>{{ trans('geo.latitude') }} <span class="latitude">{{ $latitude or '' }}</span></li>
        <li>{{ trans('geo.longitude') }} <span class="longitude">{{ $longitude or '' }}</span></li>
    </ul>
</div>
