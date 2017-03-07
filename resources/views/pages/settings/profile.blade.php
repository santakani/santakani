@extends('layouts.settings', [
    'title' => trans('common.profile'),
    'body_id' => 'profile-setting-page',
    'body_classes' => ['profile-setting-page'],
    'active_section' => 'profile',
])

@section('setting_body')

<form action="{{ url('settings/profile') }}" method="post" enctype="multipart/form-data">

    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
        <label for="name-input">{{ trans('common.name') }}</label>
        <input name="name" value="{{ old('name', $user->name) }}" type="text"
            class="form-control" id="name-input" required maxlength="255">
        @if ($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
        <label for="description-input">{{ trans('common.description') }}</label>
        <textarea name="description" class="form-control" id="description-input"
            maxlength="255">{{ old('description', $user->description) }}</textarea>
        @if ($errors->has('description'))
            <span class="help-block">
                <strong>{{ $errors->first('description') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group {{ $errors->has('avatar') ? 'has-error' : '' }}">
        <label>
            {{ trans('common.avatar') }}
        </label>

        <div id="avatar-preview" class="avatar-preview" style="background-image:url({{ $user->avatar() }})">
            <div class="text">{{ trans('image.choose_image') }}</div>
        </div>

        <input name="avatar" type="file" id="avatar-input" class="hidden" accept="image/*">

        <p class="text-muted">{{ trans('image.recommended_size', ['width' => 300, 'height' => 300]) }}</p>

        @if ($errors->has('avatar'))
            <span class="help-block">
                <strong>{{ $errors->first('avatar') }}</strong>
            </span>
        @endif
    </div>

    <button type="submit" class="btn btn-default">{{ trans('common.update') }}</button>
</form>

@endsection
