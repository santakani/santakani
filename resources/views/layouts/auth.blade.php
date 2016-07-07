@extends('layouts.app', [
    'body_classes' => isset($body_classes)?array_merge($body_classes, ['auth-page', 'auth-layout']):[],
])

@section('main')
    <div class="container">
        <div id="auth-panel" class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">@yield('panel_title')</h3>
            </div>
            <div class="panel-body">
                @yield('panel_body')
            </div>
        </div>
    </div>
@endsection
