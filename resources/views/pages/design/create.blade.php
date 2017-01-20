@extends('layouts.create', [
    'title' => trans('design.create_design'),
    'body_id' => 'story-create-page',
    'body_classes' => ['story-create-page', 'story-page'],
    'active_nav' => 'story',
])

@section('panel_title', trans('design.create_design'))

@section('panel_body')

<form class="form" action="{{ url('design') }}" method="post">

    {!! csrf_field() !!}



    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
        <label>{{ trans('common.name') }}</label>
        <input name="name" value="{{ old('name') }}" type="text" class="form-control" required maxlength="255">
        @if ($errors->has('name'))
            <span class="help-block">{{ $errors->first('name') }}</span>
        @endif
    </div>

    @if (isset($designer))
        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
            <label>{{ trans('designer.designer') }}</label>
            <input type="hidden" name="designer_id" value="{{ $designer->id }}">
            <p>{{ $designer->text('name') }}</p>
        </div>
    @endif

    <div class="form-group">
        <button type="submit" class="btn btn-primary">{{ trans('common.create') }}</button>
    </div>
</form>
@endsection
