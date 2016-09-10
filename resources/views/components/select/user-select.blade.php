<?php
if (empty($selected)) {
    $selected = null;
} elseif (is_int($selected)) {
    $selected = App\User::find($selected);
} elseif (!is_object($selected) || empty($selected->id)) {
    $selected = null;
}
?>

<select name="{{ $name or 'user_id' }}" id="{{ $id or 'user-select' }}" class="{{ $class or '' }} user-select form-control">
    @if (count($selected))
        <option value="{{ $selected->id }}" data-data="{{ $selected->toJSON() }}" selected="selected">{{ $selected->name }}</option>
    @endif
</select>
