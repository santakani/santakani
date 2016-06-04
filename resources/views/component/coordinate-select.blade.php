<div id="{{ $id or 'coordinate-select' }}" class="{{ $class or '' }} coordinate-select">
    <input type="hidden" name="latitude" value="{{ $latitude or '' }}">
    <input type="hidden" name="longitude" value="{{ $longitude or '' }}">

    <div class="map"></div>

    <ul class="list-inline text-muted">
        <li>Latitude: <span class="latitude">{{ $latitude or '' }}</span></li>
        <li>Longitude: <span class="longitude">{{ $longitude or '' }}</span></li>
    </ul>
</div>
