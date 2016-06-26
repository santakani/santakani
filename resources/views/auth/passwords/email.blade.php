@extends('layouts.auth', [
    'title' => 'Request password reset link',
    'body_id' => 'password-email-page',
    'body_classes' => ['password-email-page'],
])

@section('panel_title', 'Request password reset link')

@section('panel_body')

@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

<form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
    {!! csrf_field() !!}

    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
        <label class="col-sm-3 control-label">Email</label>

        <div class="col-sm-9">
            <input type="email" class="form-control" name="email" value="{{ old('email') }}">

            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-9 col-sm-offset-3">
            <button type="submit" class="btn btn-info">
                Send password reset link
            </button>
        </div>
    </div>
</form>
@endsection
