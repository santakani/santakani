@extends('layouts.app', [
    'title' => trans('common.register'),
    'body_id' => 'register-page',
    'body_classes' => ['register-page'],
    'active_nav' => 'register',
])

@section('main')

<div class="container">

    <header class="text-center">
        <img src="{{ url('img/logo/without-shadow.svg') }}" width="64" height="64">
        <h1>{{ trans('common.register') }}</h1>
    </header>

    <div class="row">
        <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">

            <form class="form" role="form" method="POST" action="{{ url('register') }}">

                {!! csrf_field() !!}

                {!! Honeypot::generate('username', 'birthday') !!}

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <input type="text" class="form-control input-lg" name="name" value="{{ old('name') }}" placeholder="{{ trans('common.name') }}">

                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>

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
                    <button type="submit" class="btn btn-lg btn-block btn-default">
                        {{ trans('common.register') }}
                    </button>
                </div>
                <p class="text-muted">
                    {!! trans('auth.agreement') !!}
                </p>
            </form>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container -->
@endsection
