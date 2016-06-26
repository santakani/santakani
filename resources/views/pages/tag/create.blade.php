@extends('layouts.create', [
    'title' => 'Create tag',
    'body_id' => 'tag-create-page',
    'body_classes' => ['tag-create-page'],
])

@section('panel_title', 'Create tag')

@section('panel_body')
<form class="form-horizontal" action="{{ url('tag') }}" method="post">

    {!! csrf_field() !!}

    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
        <label for="name-input" class="col-sm-3 control-label">{{ trans('common.name') }}</label>

        <div class="col-sm-9">
            <input name="name" value="{{ old('name') }}" type="text"
                required maxlength="255" class="form-control" id="name-input">
            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group {{ $errors->has('level') ? 'has-error' : '' }}">
        <label for="level-input" class="col-sm-3 control-label">Level</label>

        <div class="col-sm-9">
            <input name="level" value="{{ old('level', 0) }}" id="level-input" class="form-control"
                type="number" required min="0" max="255">
            @if ($errors->has('level'))
                <span class="help-block">
                    <strong>{{ $errors->first('level') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9">
            <button type="submit" class="btn btn-primary">{{ trans('common.create') }}</button>
        </div>
    </div>

</form>
@endsection
