<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ isset($title) ? ($title.' - Santakani') : 'Santakani - Stories of design?!' }}</title>

    <link rel="shortcut icon" href="{{ url('/favicon.png') }}" type="image/png">

    <link href="{{ url('/lib/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('/css/bootstrap.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('/css/app.css') }}" rel="stylesheet" type="text/css"/>

    <script src="{{ url('/lib/jquery/dist/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('/js/bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ url('/js/app.js') }}" type="text/javascript"></script>
</head>
<body id="min-layout" class="{{ $body_class or 'default' }}">
    <div id="kani-brand">
        <a href="{{ url('/') }}">
            <img class="logo" src="{{ url('/img/logo.png') }}" /><br/>
            <span class="santa">Santa</span><span class="kani">Kani</span>
        </a>
    </div>
    @yield('content')

    @include('modal.location')
    @include('modal.language')
</body>
</html>
