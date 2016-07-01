@extends('layouts.setting', [
    'title' => 'Account settings',
    'body_id' => 'account-setting-page',
    'body_classes' => ['account-setting-page'],
    'active_section' => 'account',
])

@section('setting_body')
<div id="email-panel" class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Email</h3>
    </div>
    <div class="panel-body">
        <form action="/setting" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            @if (empty($user->email))
                <p class="alert alert-warning">Please fill a valid email address for login.</p>
            @endif
            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                <input name="email" value="{{ old('email', $user->email) }}" type="email" class="form-control" id="email-input">
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <button type="submit" class="btn btn-default">Change email</button>
        </form>
    </div>
</div>

<div id="password-panel" class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Password</h3>
    </div>
    <div class="panel-body">
        <form action="/setting" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="email" value="{{ $user->email }}">
            @if (empty($user->password))
                <p class="alert alert-warning">Please fill a valid password for login.</p>
            @else
                <div class="form-group {{ $errors->has('old_password') ? 'has-error' : '' }}">
                    <label for="old-password-input">Old password</label>
                    <input name="old_password" value="{{ old('old_password') }}" type="password" class="form-control" id="old-password-input">
                    @if ($errors->has('old_password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('old_password') }}</strong>
                        </span>
                    @endif
                </div>
            @endif
            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                <label for="password-input">New password</label>
                <input name="password" value="{{ old('password') }}" type="password" class="form-control" id="password-input">
                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                <label for="password-confirmation-input">Confirm new password</label>
                <input name="password_confirmation" type="password" class="form-control" id="password-confirmation-input">
                @if ($errors->has('password_confirmation'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </span>
                @endif
            </div>
            <button type="submit" class="btn btn-default">Update password</button>
        </form>
    </div>
</div>

<div id="social-account-panel" class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Social accounts</h3>
    </div>
    <div class="panel-body">
        Connect social accounts to login easily and find friends.
    </div>

    <table class="table">
        <tr>
            <td class="text-primary"><i class="fa fa-facebook-official fa-lg"></i> Facebook</td>
            @if (empty($user->facebook_id))
                <td class="text-muted"><i class="fa fa-times"></i> not connected</td>
                <td><a class="btn btn-default btn-sm" href="/auth/facebook">connect</a></td>
            @else
                <td class="text-success"><i class="fa fa-check"></i> connected</td>
                <td></td>
            @endif
        </tr>
        <tr>
            <td class="text-danger"><i class="fa fa-google-plus-official fa-lg"></i> Google+</td>
            @if (empty($user->google_id))
                <td class="text-muted"><i class="fa fa-times"></i> not connected</td>
                <td><a class="btn btn-default btn-sm" href="/auth/google">connect</a></td>
            @else
                <td class="text-success"><i class="fa fa-check"></i> connected</td>
                <td></td>
            @endif
        </tr>
        <tr>
            <td class="text-info"><i class="fa fa-twitter fa-lg"></i> Twitter</td>
            @if (empty($user->twitter_id))
                <td class="text-muted"><i class="fa fa-times"></i> not connected</td>
                <td><a class="btn btn-default btn-sm" href="/auth/twitter">connect</a></td>
            @else
                <td class="text-success"><i class="fa fa-check"></i> connected</td>
                <td></td>
            @endif
        </tr>
    </table>
</div>
@endsection