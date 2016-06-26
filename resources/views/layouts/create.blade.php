@extends('layouts.app', [
    'body_classes' => isset($body_classes)?array_merge($body_classes, ['create-page', 'create-layout']):[],
])

@section('main')
<div class="container">
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">@yield('panel_title')</h3>
                </div>
                <div class="panel-body">
                    @yield('panel_body')
                </div><!-- .panel-body -->
            </div><!-- .panel -->
        </div><!-- .col -->
    </div><!-- .row -->
</div><!-- .container -->
@endsection
