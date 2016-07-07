@extends('layouts.auth', [
    'title' => trans('auth.request_password_reset_link'),
    'body_id' => 'password-email-page',
    'body_classes' => ['password-email-page'],
])

@section('panel_title', trans('auth.request_password_reset_link'))

@section('panel_body')

@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

<form class="form" role="form" method="POST" action="{{ url('/password/email') }}">
    {!! csrf_field() !!}

    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
        <label class="control-label">{{ trans('common.email_address') }}</label>

        <input type="email" class="form-control" name="email" value="{{ old('email') }}">

        @if ($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-info">{{ trans('common.send_email') }}</button>
    </div>
</form>
@endsection
