@extends('layouts.create', [
    'title' => trans('designer.create_a_designer_page'),
    'body_id' => 'designer-create-page',
    'body_classes' => ['designer-create-page', 'designer-page'],
    'active_nav' => 'designer',
])

@section('panel_title', trans('designer.create_a_designer_page'))

@section('panel_body')
    <form class="form" action="{{ url('designer') }}" method="post">

        {!! csrf_field() !!}

        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
            <label class="control-label">{{ trans('common.name') }}</label>
            <input name="name" value="{{ old('name') }}" type="text" required
                   maxlength="255" class="form-control">
            @if ($errors->has('name'))
                <span class="help-block">{{ $errors->first('name') }}</span>
            @endif
        </div>

        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
            <label class="control-label">
                {{ trans('common.email_address') }}
                <span class="label label-info">{{ trans('common.optional') }}</span>
                <span class="label label-warning">{{ trans('common.public') }}</span>
            </label>
            <input name="email" value="{{ old('email') }}" type="email"
                   maxlength="255" class="form-control">
            @if ($errors->has('email'))
                <span class="help-block">{{ $errors->first('email') }}</span>
            @endif
        </div>

        <div class="form-group {{ $errors->has('city_id') ? 'has-error' : '' }}">
            <label class="control-label">{{ trans('geo.city') }}</label>
            <select name="city_id" id="city-select" class="city-select form-control">
                @if (!empty(old('city_id')))
                    <?php $city = \App\City::find(old('city_id')); ?>
                    <option value="{{ $city->id }}" selected="selected">{{ $city->full_name }}</option>
                @endif
            </select>
            @if ($errors->has('city_id'))
                <span class="help-block">{{ $errors->first('city_id') }}</span>
            @endif
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">{{ trans('common.create') }}</button>
        </div>
    </form>
@endsection
