@extends('layout.app', [
    'title' => 'Create Place',
    'body_id' => 'place-create-page',
    'body_class' => 'place-create-page place-page create-page',
    'active_nav' => 'place',
])

@section('main')
<form class="form-horizontal" action="{{ url('place') }}" method="post">
    <div class="container">

        <h2><center>Create Place</center></h2>

        @if($errors->any())
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10 col-md-8">
                    <div class="alert alert-warning" role="alert">{{$errors->first()}}</div>
                </div>
            </div>
        @endif

        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="form-group">
            <label for="input-name" class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10 col-md-8">
                <input name="name" value="{{ old('name') }}" type="text"
                    required maxlength="255" class="form-control" id="input-name">
            </div>
        </div>

        <div class="form-group">
            <label for="place-type-select" class="col-sm-2 control-label">
                Type
            </label>

            <div class="col-sm-4 col-md-3">
                @include('component.place-type-select', [
                    'selected' => old('type'),
                    'required' => true,
                ])
            </div>
        </div>

        <div class="form-group">
            <label for="input-address" class="col-sm-2 control-label">Address</label>
            <div class="col-sm-10 col-md-8">
                <input type="text" name="address" value="{{ old('address') }}"
                    maxlength="255" class="form-control" id="input-address" required>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">
                City
            </label>

            <div class="col-sm-4 col-md-3">
                <select name="city_id" class="city-select form-control">
                    @if (!empty(old('city_id')))
                        <?php $city = \App\City::find(old('city_id')); ?>
                        <option value="{{ $city->id }}" selected="selected">{{ $city->full_name }}</option>
                    @endif
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="input-email" class="col-sm-2 control-label">Email</label>
            <div class="col-sm-10 col-md-8">
                <input name="email" value="{{ old('email') }}" type="email"
                    maxlength="255" class="form-control" id="input-email">
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">Create</button>
            </div>
        </div>
    </div>
</form>
@endsection
