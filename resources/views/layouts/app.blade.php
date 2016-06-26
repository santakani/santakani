<?php
// Default values
$has_navbar = isset($has_navbar)?$has_navbar:true;
$has_header = isset($has_header)?$has_header:true;
$has_footer = isset($has_footer)?$has_footer:true;
$body_classes = isset($body_classes)?array_merge($body_classes, ['app-layout']):[];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ isset($title) ? ($title.' - SantaKani') : 'SantaKani - Stories of design?!' }}</title>

    <link rel="shortcut icon" href="{{ url('img/logo/origin-32x32.png') }}" type="image/png" sizes="32x32">
    <link rel="shortcut icon" href="{{ url('img/logo/origin-64x64.png') }}" type="image/png" sizes="64x64">
    <link rel="shortcut icon" href="{{ url('img/logo/origin-128x128.png') }}" type="image/png" sizes="128x128">

    <!-- CSS -->
    <link href="/css/app.css" rel="stylesheet" type="text/css"/>
    @stack('styles')
</head>

<body id="{{ $body_id or 'app-layout' }}" class="{{ implode($body_classes, ' ') }}">

    @if ($has_navbar)
        @include('layouts.navbar')
    @endif

    @if ($has_header)
        <header id="site-header" class="site-header">
            @yield('header')
        </header>
    @endif

    <main>
        @yield('main')
    </main>

    @if ($has_footer)
        @include('layouts.footer')
    @endif


    <!-- Modals -->
    @if (Auth::guest())
        @include('auth.modal')
    @endif

    @stack('modals')

    <!-- Templates -->
    @stack('templates')

    <!-- Scripts -->
    @include('scripts.global')
    <script src="/lib/tinymce/tinymce.js" type="text/javascript"></script>
    <script src="/js/app.js" type="text/javascript"></script>
    @stack('scripts')

    @if(App::environment('test'))
        <div id="test-site-warning" class="alert alert-danger alert-dismissible"
            style="position:fixed;left:10px;right:10px;bottom:10px;margin:0;max-width:600px;z-index:100;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            This is a test website and may contain unknown problems. All input data
            will be flushed everyday. If you have any questions and suggestions,
            please <a href="mailto:info@santakani.com">contact us</a>.
        </div>
    @endif
</body>

</html>
