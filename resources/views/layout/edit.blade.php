<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ isset($title) ? ($title.' - SantaKani') : 'SantaKani - Stories of design?!' }}</title>

    <link rel="shortcut icon" href="{{ url('/favicon.png') }}" type="image/png">

    <link href="{{ url('/lib/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('/lib/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('/css/bootstrap.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('/css/app.css') }}" rel="stylesheet" type="text/css"/>

    <script src="{{ url('/lib/jquery/dist/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('/lib/select2/dist/js/select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('/js/bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ url('/js/app.js') }}" type="text/javascript"></script>
</head>
<body id="{{ $body_id or '' }}" class="edit-layout {{ $body_class or '' }}">
    <div id="back-link">
        <div class="container">
            <a href="{{ $back_link or url('/') }}">
                <i class="fa fa-arrow-left"></i> Back
            </a>
        </div><!-- .container -->
    </div><!-- #back-link -->


    <div id="edit-content">
        <div class="container">
            @yield('content')
        </div>
    </div>
</body>
</html>
