<?php
if (!isset($active_nav)) {
    $active_nav = '';
}

$nav_menu_left = [
    'home' => [
        'text' => trans('common.home'),
        'url' => url('/'),
        'icon' => 'home',
    ],
    'story' => [
        'text' => trans_choice('story.story', 10),
        'url' => url('story'),
        'icon' => 'book',
    ],
    'designer' => [
        'text' => trans_choice('designer.designer', 10),
        'url' => url('designer'),
        'icon' => 'users',
    ],
    'place' => [
        'text' => trans_choice('place.place', 10),
        'url' => url('place'),
        'icon' =>'map',
    ],
];

$nav_menu_right = [
    'login' => [
        'text' => trans('common.login'),
        'url' => app_redirect_url('login'),
        'icon' =>'sign-in',
    ],
    'register' => [
        'text' => trans('common.register'),
        'url' => app_redirect_url('register'),
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
        @include('components.dropdown.languages')
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
                    <span>{{ trans('common.create') }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-right">
                    <li><a href="{{ url('/designer/create') }}">{{ trans('designer.designer') }}</a></li>
                    <li><a href="{{ url('/place/create') }}">{{ trans('place.place') }}</a></li>
                    <li><a href="{{ url('/story/create') }}">{{ trans('story.story') }}</a></li>
                    @if (Auth::user()->can('create-tag'))
                        <li><a href="{{ url('/tag/create') }}">{{ trans('common.tag') }}</a></li>
                    @endif
                </ul>
            </li>

            <li class="dropdown {{ $active_nav === 'user'?'active':'' }}">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <img class="avatar" src="{{ Auth::user()->avatar('medium') }}" />
                    <span class="name hidden-xs">{{ Auth::user()->name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-right">
                    <li><a href="{{ url('setting') }}">{{ trans('common.settings') }}</a></li>
                    <li><a href="{{ url('logout') }}">{{ trans('common.logout') }}</a></li>
                </ul>
            </li>
        @endif
    </ul>
</nav>
<div class="custom-navbar-space"></div>
