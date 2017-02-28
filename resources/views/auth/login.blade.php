@extends('layouts.app', [
    'title' => trans('common.login'),
    'body_id' => 'login-page',
    'body_classes' => ['login-page'],
    'active_nav' => 'login',
])

@section('main')

<div class="container">

    <header class="text-center">
        <img src="{{ url('img/logo/without-shadow.svg') }}" width="64" height="64">
        <h1>{{ trans('common.login') }}</h1>
    </header>

    <div class="row">
        <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">

            <div id="oauth-buttons">
                <a class="btn btn-default btn-lg" href="/auth/facebook">
                    <img src="{{ url('img/services/facebook.svg') }}" width="22" height="22">
                    {{ trans('auth.login_with', ['service' => 'Facebook']) }}
                </a>

                <a class="btn btn-default btn-lg" href="/auth/google">
                    <img src="{{ url('img/services/google.svg') }}" width="22" height="22">
                    {{ trans('auth.login_with', ['service' => 'Google']) }}
                </a>

                <a class="btn btn-default btn-lg" href="/auth/twitter">
                    <img src="{{ url('img/services/twitter.svg') }}" width="22" height="22">
                    {{ trans('auth.login_with', ['service' => 'Twitter']) }}
                </a>
            </div><!-- /#oauth-buttons -->

            <p class="text-muted">{{ trans('auth.no_registration_required') }}</p>

            <hr>

            <form class="form" role="form" method="POST" action="{{ url('login') }}">

                {!! csrf_field() !!}

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <input type="email" class="form-control input-lg" name="email" value="{{ old('email') }}" placeholder="{{ trans('common.email') }}">

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <input type="password" class="form-control input-lg" name="password" placeholder="{{ trans('common.password') }}">

                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-default btn-lg btn-block">
                        {{ trans('common.login') }}
                    </button>
                </div>

                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember" checked> {{ trans('auth.remember_me') }}
                        </label>
                    </div>
                </div>

                <div class="form-group text-muted">
                    <a class="link-unstyled" href="{{ url('password/reset') }}">{{ trans('auth.forgot_your_password') }}</a>
                </div>

            </form>

            <hr>

            <p class="text-muted">{{ trans('auth.create_account_with_email') }}</p>
            <a class="btn btn-success btn-lg btn-block" href="{{ url('register') }}">{{ trans('common.register') }}</a>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container -->

@endsection
