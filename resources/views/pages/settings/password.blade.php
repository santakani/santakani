@extends('layouts.settings', [
    'title' => trans('common.account'),
    'body_id' => 'account-setting-page',
    'body_classes' => ['account-setting-page'],
    'active_section' => 'password',
])

@section('setting_body')

<h1 class="page-header">{{ trans('common.password') }}</h1>


<form class="form" action="{{ url('settings/password') }}" method="post">

    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <!-- The hidden email input helps browser to remember username and new password. -->
    <input type="email" name="email" class="hidden" value="{{ $user->email }}">

    <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
        <label for="password-input">{{ trans('auth.new_password') }}</label>
        <input name="password" value="{{ old('password') }}" type="password" class="form-control" id="password-input">
        @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
        <label for="password-confirmation-input">{{ trans('auth.confirm_password') }}</label>
        <input name="password_confirmation" type="password" class="form-control" id="password-confirmation-input">
        @if ($errors->has('password_confirmation'))
            <span class="help-block">
                <strong>{{ $errors->first('password_confirmation') }}</strong>
            </span>
        @endif
    </div>
    <button type="submit" class="btn btn-default">{{ trans('common.update') }}</button>
</form>
@endsection
