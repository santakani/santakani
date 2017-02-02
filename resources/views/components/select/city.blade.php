<?php

if (isset($selected)) {
    if (is_object($selected)) {
        $selected = $selected;
    } elseif (is_int($selected)) {
        $selected = App\City::find($selected);
    }
}

if (!empty($has_designers) && $has_designers) {
    $cities = App\City::has('designers')->get();
} else {
    $cities = App\City::has('places')->get();
}
?>

<select name="{{ $name or 'city_id' }}" id="{{ $id or 'city-select' }}"
    class="{{ $class or '' }} city-select form-control">
    @if (!empty($selected))
        <option value="{{ $selected->id }}" selected="selected" data-data="{{ $selected->toJSON() }}">{{ $selected->full_name }}</option>
    @endif
    @foreach ($cities as $city)
        <option value="{{ $city->id }}" data-data="{{ $city->toJSON() }}">{{ $city->full_name }}</option>
    @endforeach
</select>
