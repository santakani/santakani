@extends('layout.setting', [
    'title' => 'Account settings',
    'body_id' => 'account-setting-page',
    'body_class' => 'account-setting-page setting-page',
    'active_section' => 'account',
])

@section('setting_body')
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Email</h3>
    </div>
    <div class="panel-body">
        <form>
            @if (empty($user->email))
                <p class="alert alert-warning">Please fill a valid email address for login.</p>
            @endif
            <div class="form-group">
                <input name="email" value="{{ $user->email }}" type="email" class="form-control" id="email-input">
            </div>
            <button type="submit" class="btn btn-default">Change email</button>
        </form>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Password</h3>
    </div>
    <div class="panel-body">
        <form>
            @if (empty($user->password))
                <p class="alert alert-warning">Please fill a valid password for login.</p>
            @else
                <div class="form-group">
                    <label for="old-password-input">Old password</label>
                    <input name="old_password" type="password" class="form-control" id="old-password-input">
                </div>
            @endif
            <div class="form-group">
                <label for="password-input">New password</label>
                <input name="password" type="password" class="form-control" id="password-input">
            </div>
            <div class="form-group">
                <label for="password-confirmation-input">Confirm new password</label>
                <input name="password_confirmation" type="password" class="form-control" id="password-confirmation-input">
            </div>
            <button type="submit" class="btn btn-default">Update password</button>
        </form>
    </div>
</div>

<div class="panel panel-default">
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
