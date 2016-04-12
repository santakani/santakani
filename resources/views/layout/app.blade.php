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
    <link href="{{ url('/lib/flickity/dist/flickity.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('/css/bootstrap.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('/css/app.css') }}" rel="stylesheet" type="text/css"/>

    <script src="{{ url('/lib/jquery/dist/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('/lib/masonry/dist/masonry.pkgd.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('/lib/imagesloaded/imagesloaded.pkgd.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('/lib/select2/dist/js/select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('/lib/flickity/dist/flickity.pkgd.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('/js/bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ url('/js/app.js') }}" type="text/javascript"></script>
</head>
<body id="app-layout" class="{{ $body_class or 'default' }}">
    <div id="kanibar">
        <div class="first-row">
            <div id="nav-menu">
                <a id="story-menu-item" class="nav-menu-item {{ isset($active_nav) && $active_nav==='story'?'active':'' }}" href="{{ url('/') }}">
                    <img src="{{ url('/img/logo-red.png') }}" />
                    Stories
                </a>
                <a id="place-menu-item" class="nav-menu-item {{ isset($active_nav) && $active_nav==='place'?'active':'' }}" href="{{ url('/place') }}">
                    <img src="{{ url('/img/logo-green.png') }}" />
                    Places
                </a>
            </div>

            @if (Auth::guest())
                <div id="user-menu" class="not-logged-in">
                    <a href="{{ url('/login') }}">Login</a>
                    <a href="{{ url('/register') }}">Register</a>
                </div><!-- #user-menu.not-logged-in -->
            @else
                <div id="user-menu" class="dropdown logged-in">
                    <a href="#" class="avatar dropdown-toggle" style="background-image:url({{Auth::user()->getAvatarUrl()}});" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li><a href="{{ url('/dashboard') }}">
                            <i class="fa fa-fw fa-tachometer"></i> Dashboard</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="{{ url('/user/'.Auth::user()->id) }}">
                            <i class="fa fa-fw fa-user"></i> Profile</a></li>
                        <li><a href="{{ url('/notification') }}">
                            <i class="fa fa-fw fa-bell"></i> Notification</a></li>
                        <li><a href="{{ url('/setting') }}">
                            <i class="fa fa-fw fa-cog"></i> Settings</a></li>
                        <li><a href="{{ url('/logout') }}">
                            <i class="fa fa-fw fa-sign-out"></i> Logout</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#" data-toggle="modal" data-target="#language-modal">
                            <i class="fa fa-fw fa-globe"></i> English - EUR - Finland</a></li>
                    </ul>
                </div>
            @endif
        </div><!-- .first-row -->
        <div class="second-row">
            <form role="search" action="{{ url('/search') }}">
                <div class="input-group">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button"
                            data-toggle="modal" data-target="#location-modal">
                            Finland
                        </button>
                    </span>
                    <input type="search" class="form-control search-input"
                        placeholder="Search">
                </div><!-- /input-group -->
            </form>
        </div><!-- .second-row -->
    </div><!-- #kanibar -->
    @yield('content')

    @include('modal.location')
    @include('modal.language')
</body>
</html>
