@extends('layouts.create', [
    'title' => trans('story.write_a_design_story'),
    'body_id' => 'story-create-page',
    'body_classes' => ['story-create-page', 'story-page'],
    'active_nav' => 'story',
])

@section('panel_title', trans('story.write_a_design_story'))

@section('panel_body')

<form class="form" action="{{ url('story') }}" method="post">

    {!! csrf_field() !!}

    <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
        <label class="control-label">{{ trans('common.title') }}</label>
        <input name="title" value="{{ old('title') }}" type="text" required
               maxlength="255" class="form-control">
        @if ($errors->has('title'))
            <span class="help-block">{{ $errors->first('title') }}</span>
        @endif
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary">{{ trans('common.create') }}</button>
    </div>
</form>
@endsection
