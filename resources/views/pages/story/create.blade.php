@extends('layouts.create', [
    'title' => trans('story.write_design_story'),
    'body_id' => 'story-create-page',
    'body_classes' => ['story-create-page', 'story-page'],
    'active_nav' => 'story',
])

@section('panel_title', trans('story.write_design_story'))

@section('panel_body')

<form class="form-horizontal" action="{{ url('story') }}" method="post">

    {!! csrf_field() !!}

    <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
        <label for="title-input" class="col-sm-3 control-label">{{ trans('common.title') }}</label>

        <div class="col-sm-9">
            <input name="title" value="{{ old('title') }}" type="text"
                required maxlength="255" class="form-control" id="title-input">
            @if ($errors->has('title'))
                <span class="help-block">
                    <strong>{{ $errors->first('title') }}</strong>
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
