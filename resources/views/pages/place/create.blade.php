@extends('layouts.create', [
    'title' => trans('place.create_place'),
    'body_id' => 'place-create-page',
    'body_classes' => ['place-create-page', 'place-page'],
    'active_nav' => 'place',
])

@section('panel_title', trans('place.create_place'))

@section('panel_body')
    <form class="form" action="{{ url('place') }}" method="post">

        {!! csrf_field() !!}

        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
            <label class="control-label">{{ trans('common.name') }}</label>
            <input name="name" value="{{ old('name') }}" type="text" required
                   maxlength="255" class="form-control">
            @if ($errors->has('name'))
                <span class="help-block">{{ $errors->first('name') }}</span>
            @endif
        </div>

        <div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
            <label class="control-label">{{ trans('common.type') }}</label>
            @include('components.place-type-select', [
                'selected' => old('type'),
                'required' => true,
            ])
            @if ($errors->has('type'))
                <span class="help-block">{{ $errors->first('type') }}</span>
            @endif
        </div>

        <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
            <label class="control-label">{{ trans('geo.address') }}</label>
            <input name="address" value="{{ old('address') }}" type="text"
                   required maxlength="255" class="form-control" id="address-input">
            @if ($errors->has('address'))
                <span class="help-block">{{ $errors->first('address') }}</span>
            @endif
        </div>

        <div class="form-group {{ $errors->has('city_id') ? 'has-error' : '' }}">
            <label class="control-label">{{ trans('geo.city') }}</label>
            @include('components.select.city', ['selected' => old('city_id')])
            @if ($errors->has('city_id'))
                <span class="help-block">{{ $errors->first('city_id') }}</span>
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

        <div class="form-group">
            <button type="submit" class="btn btn-primary">{{ trans('common.create') }}</button>
        </div>
    </form>
@endsection
