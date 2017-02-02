<?php
$selected = isset($selected) ? $selected : null;
?>
@foreach (\App\Place::typeNames() as $key => $text)
    @if ($key === $selected)
        <label class="radio-inline">
            <input type="radio" name="{{ $name or 'type' }}" value="{{ $key }}" checked> {{ $text }}
        </label>
    @else
        <label class="radio-inline">
            <input type="radio" name="{{ $name or 'type' }}" value="{{ $key }}"> {{ $text }}
        </label>
    @endif
@endforeach
