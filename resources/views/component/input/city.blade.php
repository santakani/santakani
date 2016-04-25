<select name="{{ $name or 'city' }}" id="{{ $id or 'city-select' }}"
    class="{{ $class or '' }}">
    <option value="">{{ $placeholder or '--City--' }}</option>
    @foreach (App\City::all() as $city)
        @if (isset($selected) && $selected == $city->id)
            <option value="{{ $city->id }}" selected>{{ $city->getTranslation()->name }}</option>
        @else
            <option value="{{ $city->id }}">{{ $city->getTranslation()->name }}</option>
        @endif
    @endforeach
</select>
