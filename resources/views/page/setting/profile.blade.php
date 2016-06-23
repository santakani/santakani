@extends('layout.setting', [
    'title' => 'Profile settings',
    'body_id' => 'profile-setting-page',
    'body_classes' => ['profile-setting-page'],
    'active_section' => 'profile',
])

@section('setting_body')
<div id="basic-panel" class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Basic information</h3>
    </div>
    <div class="panel-body">
        <form action="/setting" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name-input">Name</label>
                <input name="name" value="{{ old('name', $user->name) }}" type="text"
                    class="form-control" id="name-input" required maxlength="255">
                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                <label for="description-input">Description</label>
                <textarea name="description" class="form-control" id="description-input"
                    maxlength="255">{{ old('description', $user->description) }}</textarea>
                @if ($errors->has('description'))
                    <span class="help-block">
                        <strong>{{ $errors->first('description') }}</strong>
                    </span>
                @endif
            </div>
            <button type="submit" class="btn btn-default">Update</button>
        </form>
    </div>
</div>

<div id="avatar-panel" class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Avatar</h3>
    </div>
    <div class="panel-body">
        <form action="/setting" method="post" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div id="avatar-preview" class="avatar-preview"
                style="background-image:url({{ $user->getAvatarFileUrl() }})"></div>

            <div class="form-group {{ $errors->has('avatar') ? 'has-error' : '' }}">
                <label for="avatar-input"></label>
                <input name="avatar" type="file" id="avatar-input" accept="image/*">
                @if ($errors->has('avatar'))
                    <span class="help-block">
                        <strong>{{ $errors->first('avatar') }}</strong>
                    </span>
                @endif
            </div>
            <button type="submit" class="btn btn-default">Upload avatar</button>
        </form>
    </div>
</div>
@endsection
