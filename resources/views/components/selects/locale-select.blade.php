<?php

$selected = isset($selected)?$selected:null;

?>

<select id="{{ $id or '' }}" class="{{ $class or '' }} locale-select form-control" name="{{ $name or 'locale' }}">
    @foreach(config('app.available_locale') as $locale)
        <option value="{{ $locale }}" {{ $locale === $selected ? 'selected' : '' }}>
            {{ Locale::getDisplayName($locale, 'en') }}
            @if ($locale !== 'en')
                - {{ Locale::getDisplayName($locale, $locale) }}
            @endif
        </option>
    @endforeach
</select>
