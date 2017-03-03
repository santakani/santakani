<select name="{{ $name or 'country_id' }}" id="{{ $id or 'country-select' }}" class="country-select form-control {{ $class or '' }}">
    <option value=""></option>

    @foreach (App\Country::all() as $country)
        @if (isset($selected) && $selected === $country->id)
            <option value="{{ $country->id }}" selected data-data="{{ $country }}">{{ $country->text('name') }}</option>
        @else
            <option value="{{ $country->id }}" data-data="{{ $country }}">{{ $country->text('name') }}</option>
        @endif
    @endforeach
</select>
