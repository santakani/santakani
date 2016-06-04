<?php
// Default values
$required = isset($required) ? $required : false;
$selected = isset($selected) ? $selected : null;

?>
<select id="{{ $id or 'place-type-select' }}" class="{{ $class or '' }} form-control place-type-select"
        name="{{ $name or 'type' }}" {{ $required ? 'required' : '' }}>
    @foreach (\App\Place::typesWithNames() as $key => $text)
        @if ($key === $selected)
            <option value="{{ $key }}" selected="selected">
                {{ $text }}
            </option>
        @else
            <option value="{{ $key }}">
                {{ $text }}
            </option>
        @endif
    @endforeach
</select>
