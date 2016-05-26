<?php
if (!isset($active_nav)) {
    $active_nav = '';
}

$nav_menu_left = [
    'designer' => [
        'text' => 'Designers',
        'url' => url('designer'),
    ],
    'place' => [
        'text' => 'Places',
        'url' => url('place'),
    ],
    'story' => [
        'text' => 'Stories',
        'url' => url('story'),
    ],
];

$nav_menu_right = [
    'login' => [
        'text' => 'Login',
        'url' => url('login'),
    ],
    'register' => [
        'text' => 'Register',
        'url' => url('register'),
    ],
];

?>

<nav class="custom-navbar">
    <a href="{{ url('/') }}" class="logo"></a>
    <ul class="nav-menu left">
        @foreach ($nav_menu_left as $key => $value)
            @if ($active_nav === $key)
                <li class="active"><a href="{{ $value['url'] }}">{{ $value['text'] }}</a></li>
            @else
                <li><a href="{{ $value['url'] }}">{{ $value['text'] }}</a></li>
            @endif
        @endforeach
    </ul>
    <ul class="nav-menu right">
        @if (Auth::guest())
            @foreach ($nav_menu_right as $key => $value)
            @if ($active_nav === $key)
                <li class="active"><a href="{{ $value['url'] }}">{{ $value['text'] }}</a></li>
            @else
                <li><a href="{{ $value['url'] }}">{{ $value['text'] }}</a></li>
            @endif
        @endforeach
        @else
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-plus fa-fw"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-right">
                    <li><a href="{{ url('/designer/create') }}">New Designer</a></li>
                    <li><a href="{{ url('/place/create') }}">New Place</a></li>
                    <li><a href="{{ url('/story/create') }}">New Story</a></li>
                </ul>
            </li>

            <li class="dropdown {{ $active_nav === 'user'?'active':'' }}">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-user fa-fw"></i> <span class="hidden-xs">{{ Auth::user()->name }}</span>
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
