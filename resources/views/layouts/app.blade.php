<?php
// Default values
$title = isset($title) ? $title . ' - ' . trans('brand.name') : trans('brand.name') . ' - ' . trans('brand.title');
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

    <meta name="description" content="{{ $og_description or trans('brand.description') }}">
    <meta name="keywords" content="{{ $keywords or trans('brand.keywords') }}">

    <!-- Open Graph Protocol: Facebook, Google+ -->
    <meta property="og:title" content="{{ $og_title or $title }}">
    <meta property="og:type" content="{{ $og_type or 'website' }}">
    <meta property="og:url" content="{{ $og_url or url()->current() }}">
    <meta property="og:description" content="{{ $og_description or trans('brand.description') }}">
    <meta property="og:image" content="{{ $og_image or url('img/logo/origin-512x512.png') }}">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="{{ $twitter_card_type or 'summary' }}">
    <meta name="twitter:site" content="@santakanidesign" />

    <!-- Schema.Org: Google Search -->
    <script type="application/ld+json">
    {
        "@context": "http://schema.org",
        "@type": "WebSite",
        "name": "{{ trans('brand.name') }}",
        "url": "{{ url('/') }}",
        "logo": "{{ url('img/logo/origin-512x512.png') }}",
        "potentialAction": {
            "@type": "SearchAction",
            "target": "{{ url('search') }}?q={search_term_string}",
            "query-input": "required name=search_term_string"
        }
    }
    </script>

    <!-- Chrome Android Web App -->
    <meta name="mobile-web-app-capable" content="yes">

    <!-- Favicon -->
    @foreach ([16, 32, 48, 64, 72, 96, 128, 144, 192] as $size)
    <link rel="icon" href="{{ url('img/logo/app-icon-'.$size.'.png') }}" type="image/png" sizes="{{ $size }}x{{ $size }}">
    @endforeach

    <!-- Apple Touch Icon -->
    @foreach ([120, 152, 167, 180] as $size)
    <link rel="apple-touch-icon" href="{{ url('img/logo/app-icon-'.$size.'.png') }}" type="image/png" sizes="{{ $size }}x{{ $size }}">
    @endforeach

    <!-- CSS -->
    <link href="https://fonts.googleapis.com/css?family=Lobster|Roboto+Slab|Roboto:400,400i,700" rel="stylesheet">
    <link id="app-css" href="{{ elixir('css/app.css') }}" rel="stylesheet"/>
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet"/>
    @stack('styles')
</head>

<body id="{{ $body_id or 'app-layout' }}" class="{{ implode($body_classes, ' ') }}">

    @if ($has_navbar)
        @include('layouts.app.navbar')
    @endif

    @include('layouts.app.alerts')

    <main>
        @yield('main')
    </main>

    @if ($has_footer)
        @include('layouts.app.footer')
    @endif


    <!-- Modals -->
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
