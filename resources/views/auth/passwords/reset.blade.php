@extends('layouts.auth', [
    'title' => 'Reset password',
    'body_id' => 'password-reset-page',
    'body_classes' => ['password-reset-page'],
])

@section('panel_title', 'Reset password')

@section('panel_body')
<form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">
    {!! csrf_field() !!}

    <input type="hidden" name="token" value="{{ $token }}">

    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
        <label class="col-sm-3 control-label">Email</label>

        <div class="col-sm-9">
            <input type="email" class="form-control" name="email" value="{{ $email or old('email') }}">

            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
        <label class="col-sm-3 control-label">Password</label>

        <div class="col-sm-9">
            <input type="password" class="form-control" name="password">

            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
        <label class="col-sm-3 control-label">Confirm Password</label>

        <div class="col-sm-9">
            <input type="password" class="form-control" name="password_confirmation">

            @if ($errors->has('password_confirmation'))
                <span class="help-block">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-9 col-sm-offset-3">
            <button type="submit" class="btn btn-info">
                Reset password
            </button>
        </div>
    </div>
</form>
@endsection
