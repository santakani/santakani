<nav class="custom-navbar">
    <a href="{{ url('/') }}" class="logo"></a>
    <ul class="nav-menu left">
        <li><a href="{{ url('/') }}">Stories</a></li>
        <li><a href="{{ url('/place') }}">Places</a></li>
    </ul>
    <ul class="nav-menu right">
        @if (Auth::guest())
            <li><a href="{{ url('/login') }}">Login</a></li>
            <li><a href="{{ url('/register') }}">Register</a></li>
        @else
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-plus"></i> <span class="caret"></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-right">
                    <li><a href="{{ url('/designer/create') }}">New designer</a></li>
                    <li><a href="{{ url('/place/create') }}">New place</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-user"></i> <span class="hidden-xs">{{ Auth::user()->name }}</span> <span class="caret"></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-right">
                    <li><a href="{{ url('/user/'.Auth::user()->id) }}">Profile</a></li>
                    <li><a href="{{ url('/help') }}">Help</a></li>
                    <li><a href="{{ url('/setting') }}">Settings</a></li>
                    <li><a href="{{ url('/logout') }}">Logout</a></li>
                </ul>
            </li>
        @endif
    </ul>
</nav>
<div class="custom-navbar-space"></div>
