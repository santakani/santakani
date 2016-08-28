<?php
if (!isset($active_nav)) {
    $active_nav = '';
}

$nav_menu_left = [
    'home' => [
        'text' => trans('common.home'),
        'url' => url('/'),
    ],
    'design' => [
        'text' => trans('designer.designs'),
        'url' => url('design'),
    ],
    'designer' => [
        'text' => trans('designer.designers'),
        'url' => url('designer'),
    ],

    'place' => [
        'text' => trans('place.places'),
        'url' => url('place'),
    ],
    'story' => [
        'text' => trans('story.stories'),
        'url' => url('story'),
    ],
];

$nav_menu_right = [
    'login' => [
        'text' => trans('common.login'),
        'url' => app_redirect_url('login'),
    ],
    'register' => [
        'text' => trans('common.register'),
        'url' => app_redirect_url('register'),
    ],
];

?>

<nav class="custom-navbar">
    <a href="{{ url('/') }}" class="logo"></a>
    <ul class="nav-menu">
        @foreach ($nav_menu_left as $key => $value)
            <li class="{{ $active_nav === $key?'active':'' }}">
                <a href="{{ $value['url'] }}">
                    <span class="stroke-icon icon-{{ $key }}"></span>
                    <span class="text hidden-xs">{{ $value['text'] }}</span>
                </a>
            </li>
        @endforeach
        <li class="space"></li>
        @include('components.dropdown.languages')
        @if (Auth::guest())
            @foreach ($nav_menu_right as $key => $value)
                <li class="{{ $active_nav === $key?'active':'' }}">
                    <a href="{{ $value['url'] }}">
                        <span class="stroke-icon icon-{{ $key }}"></span>
                        <span class="text hidden-xs">{{ $value['text'] }}</span>
                    </a>
                </li>
            @endforeach
        @else
            <li class="dropdown hidden-xs">
                <a href="#" class="create dropdown-toggle" data-toggle="dropdown">
                    <span class="stroke-icon icon-create"></span>
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
                    @if (Auth::user()->role === 'admin')
                        <li><a href="/admin">Admin panel</a></li>
                        <li role="separator" class="divider"></li>
                    @endif
                    <?php
                        $designer_count = Auth::user()->designers()->count();
                        $place_count = Auth::user()->places()->count();
                    ?>
                    @if ($designer_count)
                        <li class="dropdown-header">{{ trans('designer.designer_pages') }}</li>
                        @foreach (Auth::user()->designers()->take(5)->get() as $designer)
                            <li><a href="{{ $designer->url }}">{{ $designer->text('name') }}</a></li>
                        @endforeach
                        @if ($designer_count > 5)
                            <li><a href="{{ url('setting/page') }}">{{ trans('common.more') }}...</a></li>
                        @endif
                    @endif
                    @if ($place_count)
                        <li class="dropdown-header">{{ trans('place.place_pages') }}</li>
                        @foreach (Auth::user()->places()->take(5)->get() as $place)
                            <li><a href="{{ $place->url }}">{{ $place->text('name') }}</a></li>
                        @endforeach
                        @if ($place_count > 5)
                            <li><a href="{{ url('setting/page') }}">{{ trans('common.more') }}...</a></li>
                        @endif
                        <li role="separator" class="divider"></li>
                    @endif
                    <li><a href="{{ Auth::user()->url }}">{{ trans('common.profile') }}</a></li>
                    <li><a href="{{ url('setting') }}">{{ trans('common.settings') }}</a></li>
                    <li><a href="{{ url('logout') }}">{{ trans('common.logout') }}</a></li>
                </ul>
            </li>
        @endif
    </ul>
</nav>
<div class="custom-navbar-space"></div>
