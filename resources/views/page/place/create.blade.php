@extends('layout.create', [
    'title' => trans('place.create_place_page'),
    'body_id' => 'place-create-page',
    'body_classes' => ['place-create-page', 'place-page'],
    'active_nav' => 'place',
])

@section('panel_title', trans('place.create_place_page'))

@section('panel_body')
<form class="form-horizontal" action="{{ url('place') }}" method="post">

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

    <div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
        <label for="type-select" class="col-sm-3 control-label">Type</label>

        <div class="col-sm-9">
            @include('component.place-type-select', [
                'id' => 'type-select',
                'selected' => old('type'),
                'required' => true,
            ])
            @if ($errors->has('type'))
                <span class="help-block">
                    <strong>{{ $errors->first('type') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
        <label for="address-input" class="col-sm-3 control-label">{{ trans('place.address') }}</label>

        <div class="col-sm-9">
            <input name="address" value="{{ old('address') }}" type="text"
                required maxlength="255" class="form-control" id="address-input">
            @if ($errors->has('address'))
                <span class="help-block">
                    <strong>{{ $errors->first('address') }}</strong>
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

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9">
            <button type="submit" class="btn btn-primary">{{ trans('common.create') }}</button>
        </div>
    </div>
</form>
@endsection
