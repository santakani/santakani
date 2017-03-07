@extends('layouts.settings', [
    'title' => trans('common.account'),
    'body_id' => 'account-setting-page',
    'body_classes' => ['account-setting-page'],
    'active_section' => 'account',
])

@section('setting_body')

<h1 class="page-header">{{ trans('common.account') }}</h1>

<form class="form-horizontal" action="{{ url('settings/account') }}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
        <label class="col-sm-3 control-label">{{ trans('common.email') }}</label>
        <div class="col-sm-9">
            <input name="email" value="{{ old('email', $user->email) }}" type="email" class="form-control" id="email-input">
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group {{ $errors->has('locale') ? 'has-error' : '' }}">
        <label class="col-sm-3 control-label">{{ trans('common.language') }}</label>
        <div class="col-sm-9">
            @include('components.selects.locale-select', ['selected' => $user->locale])
            @if ($errors->has('locale'))
                <span class="help-block">
                    <strong>{{ $errors->first('locale') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9">
            <button type="submit" class="btn btn-default">{{ trans('common.update') }}</button>
        </div>
    </div>
</form>

<hr>

<div class="row">
    <div class="col-sm-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <img src="{{ url('img/services/facebook.svg') }}" width="32" height="32">

                Facebook

                @if (empty($user->facebook_id))
                    <a class="btn btn-default pull-right" href="/auth/facebook">{{ trans('common.connect') }}</a>
                @else
                    <span class="text-success pull-right">{{ trans('common.connected') }}</span>
                @endif
            </div><!-- /.panel-body -->
        </div><!-- /.panel -->
    </div><!-- /.col -->

    <div class="col-sm-6">

        <div class="panel panel-default">
            <div class="panel-body">
                <img src="{{ url('img/services/google.svg') }}" width="32" height="32">

                Google

                @if (empty($user->google_id))
                    <a class="btn btn-default pull-right" href="/auth/google">{{ trans('common.connect') }}</a>
                @else
                    <span class="text-success pull-right">{{ trans('common.connected') }}</span>
                @endif
            </div>
        </div>
    </div><!-- /.col -->

    <div class="col-sm-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <img src="{{ url('img/services/twitter.svg') }}" width="32" height="32">

                Twitter

                @if (empty($user->twitter_id))
                    <a class="btn btn-default pull-right" href="/auth/twitter">{{ trans('common.connect') }}</a>
                @else
                    <span class="text-success pull-right">{{ trans('common.connected') }}</span>
                @endif
            </div>
        </div>
    </div><!-- /.col -->
</div><!-- /.row -->

@endsection
