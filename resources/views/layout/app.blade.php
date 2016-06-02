<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ isset($title) ? ($title.' - SantaKani') : 'SantaKani - Stories of design?!' }}</title>

    <link rel="shortcut icon" href="/favicon.png" type="image/png">

    <!-- CSS -->
    <link href="/css/app.css" rel="stylesheet" type="text/css"/>
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
    <script src="/lib/tinymce/tinymce.js" type="text/javascript"></script>
    <script src="/js/app.js" type="text/javascript"></script>
    <script type="text/javascript">
        // Global variables from server
        var csrfToken = "{!! csrf_token() !!}";
    </script>
    @stack('scripts')
</body>

</html>
