<?php

if (isset($selected)) {
    if (is_object($selected)) {
        $city = $selected;
    } elseif (is_int($selected)) {
        $city = App\City::find($selected);
    }
}

?>

<select name="{{ $name or 'city_id' }}" id="{{ $id or 'city-select' }}"
    class="{{ $class or '' }} city-select form-control">
    @if (!empty($selected))
        <option value="{{ $city->id }}" selected="selected"
                data-data="{{ $city->toJSON() }}">{{ $city->full_name }}</option>
    @endif
</select>
