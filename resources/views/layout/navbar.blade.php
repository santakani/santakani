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
</div><!-- #kanibar -->
