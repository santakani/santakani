<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ isset($title) ? ($title.' - Santakani') : 'Santakani - Discover independent design from Finland' }}</title>

    <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="bower_components/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css"/>
    <link href="css/app.css" rel="stylesheet" type="text/css"/>

    <script src="bower_components/jquery/dist/jquery.min.js" type="text/javascript"></script>
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="bower_components/masonry/dist/masonry.pkgd.min.js" type="text/javascript"></script>
    <script src="bower_components/imagesloaded/imagesloaded.pkgd.min.js" type="text/javascript"></script>
    <script src="bower_components/select2/dist/js/select2.min.js" type="text/javascript"></script>
    <script src="js/app.js" type="text/javascript"></script>
</head>
<body id="app-layout">
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#navbar-collapse" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <i class="fa fa-lg fa-fw fa-bars"></i>
                </button>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#navbar-search-collapse" aria-expanded="false">
                    <span class="sr-only">Toggle Search</span>
                    <i class="fa fa-lg fa-fw fa-search"></i>
                </button>
                <a class="navbar-brand" href="{{ url('/') }}">Santakani</a>
            </div>

            <div class="collapse" id="navbar-search-collapse">
                <form role="search" action="search.html">
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
            </div>

            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="index.html"><i class="fa fa-fw fa-home"></i> Home</a></li>
                    <li><a href="map.html"><i class="fa fa-fw fa-map-marker"></i> Map</a></li>
                    <li><a href="tags.html"><i class="fa fa-fw fa-tag"></i> Tags</a></li>
                    <li><a href="read.html"><i class="fa fa-fw fa-bookmark"></i> Read</a></li>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="dashboard.html">
                                    <i class="fa fa-fw fa-tachometer"></i> Dashboard</a></li>

                                <li role="separator" class="divider"></li>
                                <li><a href="designer.html">Mai Niemi (Designer)</a></li>
                                <li><a href="shop.html">MAINIEMI SHOP Helsinki (Shop)</a></li>
                                <li><a href="shop.html">MAINIEMI SHOP Oulu (Shop)</a></li>

                                <li role="separator" class="divider"></li>
                                <li><a href="user-profile.html">
                                    <i class="fa fa-fw fa-user"></i> Profile</a></li>
                                <li><a href="user-notification.html">
                                    <i class="fa fa-fw fa-bell"></i> Notification</a></li>
                                <li><a href="user-settings.html">
                                    <i class="fa fa-fw fa-cog"></i> Settings</a></li>
                                <li><a href="{{ url('/logout') }}">
                                    <i class="fa fa-fw fa-sign-out"></i> Logout</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="#" data-toggle="modal" data-target="#language-modal">
                                    <i class="fa fa-fw fa-globe"></i> English - EUR - Finland</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>

                <form class="navbar-form navbar-right hidden-xs" role="search"
                    action="search.html">
                    <div class="input-group">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button" data-toggle="modal"
                                data-target="#location-modal">Finland</button>
                        </span>
                        <input type="search" class="form-control search-input"
                            placeholder="Search">
                    </div><!-- /input-group -->
                </form>
            </div><!-- /.navbar-collapse -->
        </div><!-- .container-fluid -->
    </nav>

    @yield('content')
</body>
</html>
