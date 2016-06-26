@extends('layouts.auth', [
    'title' => trans('common.login'),
    'body_id' => 'login-page',
    'body_classes' => ['login-page'],
    'active_nav' => 'login',
])

@section('panel_title', trans('common.login'))

@section('panel_body')
<form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
    <div class="form-group">
        <div class="col-sm-6 col-sm-offset-3">
            <a class="btn btn-primary btn-lg btn-block" href="/auth/facebook">
                <i class="fa fa-facebook-official fa-lg"></i>
                Facebook {{ trans('common.login') }}
            </a>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-6 col-sm-offset-3">
            <a class="btn btn-danger btn-lg btn-block" href="/auth/google">
                <i class="fa fa-google fa-lg"></i>
                Google {{ trans('common.login') }}
            </a>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-6 col-sm-offset-3">
            <a class="btn btn-info btn-lg btn-block" href="/auth/twitter">
                <i class="fa fa-twitter fa-lg"></i>
                Twitter {{ trans('common.login') }}
            </a>
        </div>
    </div>

    <p class="text-center text-muted">{{ strtolower(trans('common.or')) }}</p>

    {!! csrf_field() !!}

    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
        <label class="col-sm-3 control-label">{{ trans('common.email') }}</label>

        <div class="col-sm-8 col-lg-6">
            <input type="email" class="form-control" name="email" value="{{ old('email') }}">

            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
        <label class="col-sm-3 control-label">{{ trans('common.password') }}</label>

        <div class="col-sm-8 col-lg-6">
            <input type="password" class="form-control" name="password">

            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-9 col-sm-offset-3">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="remember"> Remember me
                </label>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-9 col-sm-offset-3">
            <button type="submit" class="btn btn-info">
                {{ trans('common.login') }}
            </button>

            <a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot your password?</a>
        </div>
    </div>
</form>
@endsection
