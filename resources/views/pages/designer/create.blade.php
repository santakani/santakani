@extends('layout.create', [
    'title' => 'Create designer profile',
    'body_id' => 'designer-create-page',
    'body_classes' => ['designer-create-page', 'designer-page'],
    'active_nav' => 'designer',
])

@section('panel_title', 'Create designer profile')

@section('panel_body')
<form class="form-horizontal" action="{{ url('designer') }}" method="post">

    {!! csrf_field() !!}

    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
        <label for="name-input" class="col-sm-3 control-label">{{ trans('common.name') }}</label>

        <div class="col-sm-9">
            <input name="name" value="{{ old('name') }}" type="text"
                required maxlength="255" class="form-control" id="name-input"
                placeholder="Full name of the designer or brand">
            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
        <label for="email-input" class="col-sm-3 control-label">{{ trans('common.email') }}</label>

        <div class="col-sm-9">
            <input name="email" value="{{ old('email') }}" type="email"
                maxlength="255" class="form-control" id="email-input">
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group {{ $errors->has('city_id') ? 'has-error' : '' }}">
        <label for="city-select" class="col-sm-3 control-label">{{ trans('city.city') }}</label>

        <div class="col-sm-9">
            <select name="city_id" id="city-select" class="city-select form-control">
                @if (!empty(old('city_id')))
                    <?php $city = \App\City::find(old('city_id')); ?>
                    <option value="{{ $city->id }}" selected="selected">{{ $city->full_name }}</option>
                @endif
            </select>
            @if ($errors->has('city_id'))
                <span class="help-block">
                    <strong>{{ $errors->first('city_id') }}</strong>
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
