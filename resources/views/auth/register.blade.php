@extends('layouts.auth', [
    'title' => trans('common.register'),
    'body_id' => 'register-page',
    'body_classes' => ['register-page'],
    'active_nav' => 'register',
])

@section('panel_title', trans('common.register'))

@section('panel_body')

<form class="form" role="form" method="POST" action="{{ url('/register') }}">
    <div class="form-group">
        <a class="btn btn-primary btn-lg btn-block" href="/auth/facebook">
            <i class="fa fa-facebook-official fa-lg"></i>
            Facebook {{ trans('common.login') }}
        </a>
    </div>

    <div class="form-group">
        <a class="btn btn-danger btn-lg btn-block" href="/auth/google">
            <i class="fa fa-google fa-lg"></i>
            Google {{ trans('common.login') }}
        </a>
    </div>

    <div class="form-group">
        <a class="btn btn-info btn-lg btn-block" href="/auth/twitter">
            <i class="fa fa-twitter fa-lg"></i>
            Twitter {{ trans('common.login') }}
        </a>
    </div>

    <p class="text-center text-muted">{{ strtolower(trans('common.or')) }}</p>

    {!! csrf_field() !!}

    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
        <label class="control-label">{{ trans('common.name') }}</label>
        <input type="text" class="form-control" name="name" value="{{ old('name') }}">

        @if ($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
        <label class="control-label">{{ trans('common.email_address') }}</label>
        <input type="email" class="form-control" name="email" value="{{ old('email') }}">

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
            {{ trans('common.register') }}
        </button>
    </div>
</form>
@endsection
