<?php
// Default values
$title = isset($title) ? $title . ' - ' . trans('brand.app_name') : trans('brand.app_name') . ': ' . trans('brand.app_define');
$has_navbar = isset($has_navbar)?$has_navbar:true;
$has_header = isset($has_header)?$has_header:true;
$has_footer = isset($has_footer)?$has_footer:true;
$body_classes = isset($body_classes)?array_merge($body_classes, ['app-layout']):['app-layout'];
?>

<!DOCTYPE html>
<html lang="{{ App::getLocale() }}" prefix="og: http://ogp.me/ns#">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title }}</title>

    <meta name="description" content="{{ $og_description or trans('brand.app_description') }}">

    <!-- Open Graph Protocol: Facebook, Google+ -->
    <meta property="og:title" content="{{ $og_title or $title }}">
    <meta property="og:type" content="{{ $og_type or 'website' }}">
    <meta property="og:url" content="{{ $og_url or url()->current() }}">
    <meta property="og:description" content="{{ $og_description or trans('brand.app_description') }}">
    <meta property="og:image" content="{{ $og_image or url('img/logo/origin-512x512.png') }}">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="{{ $twitter_card_type or 'summary' }}">
    <meta name="twitter:site" content="@santakanidesign" />

    <!-- Schema.Org: Google Search -->
    <script type="application/ld+json">
    {
        "@context": "http://schema.org",
        "@type": "WebSite",
        "name": "{{ trans('brand.app_name') }}",
        "url": "{{ url('/') }}",
        "logo": "{{ url('img/logo/origin-512x512.png') }}",
        "potentialAction": {
            "@type": "SearchAction",
            "target": "{{ url('search') }}?q={search_term_string}",
            "query-input": "required name=search_term_string"
        }
    }
    </script>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ url('img/logo/origin-32x32.png') }}" type="image/png" sizes="32x32">
    <link rel="shortcut icon" href="{{ url('img/logo/origin-64x64.png') }}" type="image/png" sizes="64x64">
    <link rel="shortcut icon" href="{{ url('img/logo/origin-128x128.png') }}" type="image/png" sizes="128x128">

    <!-- Apple Touch Icon -->
    <link rel="apple-touch-icon" href="{{ url('img/logo/apple-touch-icon-120x120.png') }}" type="image/png" sizes="120x120">
    <link rel="apple-touch-icon" href="{{ url('img/logo/apple-touch-icon-152x152.png') }}" type="image/png" sizes="152x152">
    <link rel="apple-touch-icon" href="{{ url('img/logo/apple-touch-icon-167x167.png') }}" type="image/png" sizes="167x167">
    <link rel="apple-touch-icon" href="{{ url('img/logo/apple-touch-icon-180x180.png') }}" type="image/png" sizes="180x180">

    <!-- CSS -->
    <link id="app-css" href="{{ elixir('css/app.css') }}" rel="stylesheet" type="text/css"/>
    @stack('styles')
</head>

<body id="{{ $body_id or 'app-layout' }}" class="{{ implode($body_classes, ' ') }}">

    @if ($has_navbar)
        @include('layouts.app.navbar')
    @endif

    @if ($has_header)
        <header id="app-header" class="app-header {{ $header_class or '' }}">
            @yield('header')
        </header>
    @endif

    <main>
        @yield('main')
    </main>

    @if ($has_footer)
        @include('layouts.app.footer')
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
    <script src="{{ elixir('js/app.js') }}" type="text/javascript"></script>
    @if (App::environment('production'))
        @include('scripts.analytics')
    @endif
    @if (isset($has_share_buttons) && $has_share_buttons)
        @include('scripts.addthis')
    @endif
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
