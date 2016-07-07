@extends('layouts.auth', [
    'title' => trans('auth.reset_password'),
    'body_id' => 'password-reset-page',
    'body_classes' => ['password-reset-page'],
])

@section('panel_title', trans('auth.reset_password'))

@section('panel_body')
<form class="form" role="form" method="POST" action="{{ url('/password/reset') }}">
    {!! csrf_field() !!}

    <input type="hidden" name="token" value="{{ $token }}">

    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
        <label class="control-label">{{ trans('common.email_address') }}</label>

        <input type="email" class="form-control" name="email" value="{{ $email or old('email') }}">

        @if ($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
        <label class="control-label">{{ trans('common.password') }}</label>

        <input type="password" class="form-control" name="password">

        @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
        <label class="control-label">{{ trans('auth.confirm_password') }}</label>

        <input type="password" class="form-control" name="password_confirmation">

        @if ($errors->has('password_confirmation'))
            <span class="help-block">
                <strong>{{ $errors->first('password_confirmation') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-info">
            {{ trans('auth.reset_password') }}
        </button>
    </div>
</form>
@endsection
