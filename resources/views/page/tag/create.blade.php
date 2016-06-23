@extends('layout.app', [
    'title' => 'Create tag',
    'body_id' => 'tag-create-page',
    'body_classes' => ['tag-create-page'],
    'active_nav' => 'tag',
])

@section('main')
<div class="container">
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Create tag</h3>
                </div>
                <div class="panel-body">
                    <form id="tag-create-form" class="form-horizontal" action="/tag" method="post">

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                            <label for="name-input" class="col-sm-4 control-label">
                                Name ({{ trans('languages.english') }})
                            </label>

                            <div class="col-sm-8">
                                <input name="name" value="{{ old('name') }}" id="name-input" class="form-control"
                                    type="text" required maxlength="255">
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('level') ? 'has-error' : '' }}">
                            <label for="level-input" class="col-sm-4 control-label">
                                Level
                            </label>

                            <div class="col-sm-8">
                                <input name="level" value="{{ old('level', 0) }}" id="level-input" class="form-control"
                                    type="number" required min="0" max="255">
                                @if ($errors->has('level'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('level') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8">
                                <button type="submit" class="btn btn-default">Create</button>
                            </div>
                        </div>

                    </form>
                </div><!-- .panel-body -->
            </div><!-- .panel -->
        </div><!-- .col -->
    </div><!-- .row -->
</div><!-- .container -->
@endsection
