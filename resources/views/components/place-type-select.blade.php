<?php
// Default values
$required = isset($required) ? $required : false;
$selected = isset($selected) ? $selected : null;
$all = isset($all) ? $all : false;;
?>
<select id="{{ $id or 'place-type-select' }}" class="{{ $class or '' }} form-control place-type-select"
        name="{{ $name or 'type' }}" {{ $required ? 'required' : '' }}>
    @if ($all)
        <option value="">{{ trans('common.all') }}</option>
    @endif
    @foreach (\App\Place::typeNames() as $key => $text)
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
