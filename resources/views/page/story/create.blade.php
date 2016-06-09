@extends('layout.app', [
    'title' => 'Create Story',
    'body_id' => 'story-create-page',
    'body_class' => 'story-create-page story-page create-page',
    'active_nav' => 'story',
])

@section('header')
<header>
    <div class="container">
        <div class="row">
            <div class="col-sm-offset-2 sol-sm-10 col-md-8">
                <h1 class="page-header">Create Story</h1>
            </div>
        </div>
    </div>
</header>
@endsection

@section('main')
<form class="form-horizontal" action="{{ url('story') }}" method="post">
    <div class="container">

        @if($errors->any())
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10 col-md-8">
                    <div class="alert alert-warning" role="alert">{{$errors->first()}}</div>
                </div>
            </div>
        @endif

        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="form-group">
            <label for="title-input" class="col-sm-2 control-label">Title</label>

            <div class="col-sm-10 col-md-8">
                <input name="title" value="{{ old('title') }}" type="text"
                    required maxlength="255" class="form-control" id="title-input">
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
