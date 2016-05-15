<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ isset($title) ? ($title.' - SantaKani') : 'SantaKani - Stories of design?!' }}</title>

    <link rel="shortcut icon" href="{{ url('/favicon.png') }}" type="image/png">

    <!-- CSS -->
    <link href="{{ url('/lib/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('/lib/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('/lib/flickity/dist/flickity.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('/lib/lightgallery/dist/css/lightgallery.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('/css/app.css') }}" rel="stylesheet" type="text/css"/>
    @stack('styles')
</head>

<body id="{{ $body_id or 'app-layout' }}" class="app-layout {{ $body_class or '' }}">

    @if (!isset($has_navbar) || $has_navbar)
        @include('layout.navbar')
    @endif

    @yield('header')

    <main>
        @yield('main')
    </main>

    @if (!isset($has_footer) || $has_footer)
        @include('layout.footer')
    @endif

    @stack('modals')

    @stack('templates')

    <!-- JavaScript -->
    <script src="{{ url('/lib/jquery/dist/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('/lib/masonry/dist/masonry.pkgd.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('/lib/imagesloaded/imagesloaded.pkgd.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('/lib/select2/dist/js/select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('/lib/tinymce/tinymce.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('/lib/flickity/dist/flickity.pkgd.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('/lib/lightgallery/dist/js/lightgallery-all.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('/lib/Sortable/Sortable.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('/lib/background-check/background-check.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('/lib/bootstrap-sass/assets/javascripts/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="/lib/underscore/underscore-min.js" type="text/javascript"></script>
    <script src="/lib/backbone/backbone-min.js" type="text/javascript"></script>
    <script src="{{ url('/js/app.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        // Global variables from server
        var csrfToken = "{!! csrf_token() !!}";
    </script>
    @stack('scripts')
</body>

</html>
