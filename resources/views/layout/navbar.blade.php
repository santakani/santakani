<?php
if (!isset($active_nav)) {
    $active_nav = '';
}

$nav_menu_left = [
    'home' => [
        'text' => 'Home',
        'url' => url('/'),
        'icon' => 'home',
    ],
    'story' => [
        'text' => 'Stories',
        'url' => url('story'),
        'icon' => 'book',
    ],
    'designer' => [
        'text' => 'Designers',
        'url' => url('designer'),
        'icon' => 'users',
    ],
    'place' => [
        'text' => 'Places',
        'url' => url('place'),
        'icon' =>'map',
    ],
];

$nav_menu_right = [
    'login' => [
        'text' => 'Login',
        'url' => url('login?redirect=' . request()->url()),
        'icon' =>'sign-in',
    ],
    'register' => [
        'text' => 'Register',
        'url' => url('register?redirect=' . request()->url()),
        'icon' =>'user-plus',
    ],
];

?>

<nav class="custom-navbar">
    <a href="{{ url('/') }}" class="logo"></a>
    <ul class="nav-menu left">
        @foreach ($nav_menu_left as $key => $value)
            <li class="{{ $active_nav === $key?'active':'' }}">
                <a href="{{ $value['url'] }}">
                    <i class="fa fa-{{ $value['icon'] }}"></i>
                    <span>{{ $value['text'] }}</span>
                </a>
            </li>
        @endforeach
    </ul>
    <ul class="nav-menu right">
        @if (Auth::guest())
            @foreach ($nav_menu_right as $key => $value)
                <li class="{{ $active_nav === $key?'active':'' }}">
                    <a href="{{ $value['url'] }}">
                        <i class="fa fa-{{ $value['icon'] }}"></i>
                        <span class="text">{{ $value['text'] }}</span>
                    </a>
                </li>
            @endforeach
        @else
            <li class="dropdown">
                <a href="#" class="dropdown-toggle bg-primary" data-toggle="dropdown">
                    <i class="fa fa-plus"></i>
                    <span>Create</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-right">
                    <li><a href="{{ url('/designer/create') }}">New designer</a></li>
                    <li><a href="{{ url('/place/create') }}">New place</a></li>
                    <li><a href="{{ url('/story/create') }}">New story</a></li>
                    @if (Auth::user()->can('create-tag'))
                        <li><a href="{{ url('/tag/create') }}">New tag</a></li>
                    @endif
                </ul>
            </li>

            <li class="dropdown {{ $active_nav === 'user'?'active':'' }}">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <img class="avatar" src="{{ Auth::user()->getAvatarFileUrl('medium') }}" />
                    <span class="name hidden-xs">{{ Auth::user()->name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-right">
                    <li><a href="{{ url('setting') }}">Settings</a></li>
                    <li><a href="{{ url('logout?redirect='. request()->url()) }}">Logout</a></li>
                </ul>
            </li>
        @endif
    </ul>
</nav>
<div class="custom-navbar-space"></div>
