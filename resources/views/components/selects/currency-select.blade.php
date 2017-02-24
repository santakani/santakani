<select id="{{ $id or '' }}" class="{{ $class or ''}} currency-select form-control" name="{{ $name or 'currency' }}">
    @foreach (App\Localization\Currencies::all() as $currency)
        <option value="{{ $currency }}" {{ isset($selected) && $selected === $currency?'selected':'' }} data-rate="{{ App\Localization\Currencies::rate($currency) }}">{{ $currency }} &ndash; {{ App\Localization\Currencies::name($currency) }}</option>
    @endforeach
</select>
