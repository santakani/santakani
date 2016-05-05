<!DOCTYPE html>
<html>
    <head>
        <title>{{ $error_name }}.</title>

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
                font-family: 'Roboto';
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
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">{{ $error_code }}&ndash;{{ $error_name }}.</div>
                <div class="description">@yield('error_desc')</div>
                <div class="back">
                    <a href="{{ url('/') }}">Return home</a>
                </div>
            </div>
        </div>
    </body>
</html>
