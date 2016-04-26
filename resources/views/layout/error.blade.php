<!DOCTYPE html>
<html>
    <head>
        <title>{{ $error_name }}.</title>

        <link href="{{ url('lib/lato/css/lato.min.css') }}" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #B0BEC5;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 72px;
                margin-bottom: 40px;
            }

            a {
                color: #B0BEC5;
                font-weight: 300;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">{{ $error_code }}&ndash;{{ $error_name }}.</div>
                <div class="description">@yield('error_desc')</div>
                <div class="back">
                    <a href="{{ url('/') }}">Return home &#8640;</a>
                </div>
            </div>
        </div>
    </body>
</html>
