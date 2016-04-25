<select name="{{ $name or 'country' }}" id="{{ $id or 'country-select' }}"
    class="{{ $class or '' }}">
    <option value="">{{ $placeholder or '--Country--' }}</option>
    @foreach (App\Country::all() as $country)
        @if (isset($selected) && $selected == $country->id)
            <option value="{{ $country->id }}" selected>{{ $country->getTranslation()->name }}</option>
        @else
            <option value="{{ $country->id }}">{{ $country->getTranslation()->name }}</option>
        @endif

    @endforeach
</select>
