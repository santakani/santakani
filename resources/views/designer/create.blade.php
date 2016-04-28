@extends('layout.app', [
    'title' => 'New Designer Story',
    'body_id' => 'designer-create-page',
    'body_class' => 'designer-create-page',
])

@section('content')
<form class="form-horizontal" action="{{ url('designer') }}" method="post">
    <div class="container">
        <h1 class="page-header"><center>Create A Story Of A Designer/Brand</center></h1>
        @if($errors->any())
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <div class="alert alert-warning" role="alert">{{$errors->first()}}</div>
                </div>
            </div>
        @endif
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="form-group">
            <label for="input-name" class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10">
                <input name="name" value="{{ old('name') }}" type="text"
                    required maxlength="255" class="form-control" id="input-name"
                    placeholder="Full name of the designer or brand">
            </div>
        </div>

        <div class="form-group">
            <label for="input-tagline" class="col-sm-2 control-label">Tagline</label>
            <div class="col-sm-10">
                <textarea name="tagline" rows="2" maxlength="255" class="form-control"
                    id="input-tagline" placeholder="Express your design philosophy in short"
                    >{{ old('tagline') }}</textarea>
                <p class="text-muted">Max. 255 characters.</p>
            </div>
        </div>

        <div class="form-group">
            <label for="input-email" class="col-sm-2 control-label">Email</label>
            <div class="col-sm-10">
                <input name="email" value="{{ old('email') }}" type="email"
                    maxlength="255" class="form-control" id="input-email">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">Location</label>
            <div class="col-sm-5 col-md-3">
                @include('component.input.country', ['class' => 'form-control', 'selected' => old('country')])
            </div>
            <div class="col-sm-5 col-md-3">
                @include('component.input.city', ['class' => 'form-control', 'selected' => old('city')])
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
