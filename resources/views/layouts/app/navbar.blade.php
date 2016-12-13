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
        'text' => trans('design.designs'),
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

if ($nav_no_design) {
    unset($nav_menu_left['design']);
}

if ($nav_no_story) {
    unset($nav_menu_left['story']);
}


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
            <li>
                <a href="{{ app_redirect_url('login') }}">
                    <span class="stroke-icon icon-login"></span>
                    <span class="text hidden-xs">{{ trans('common.login') }}</span>
                </a>
            </li>
            <li class="hidden-xs">
                <a href="{{ app_redirect_url('register') }}">
                    <span class="stroke-icon icon-register"></span>
                    <span class="text hidden-xs">{{ trans('common.register') }}</span>
                </a>
            </li>
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
                        @foreach (Auth::user()->designers()->take(4)->get() as $designer)
                            <li><a href="{{ $designer->url }}">{{ $designer->text('name') }}</a></li>
                        @endforeach
                        <li role="separator" class="divider"></li>
                    @endif
                    @if ($place_count)
                        <li class="dropdown-header">{{ trans('place.place_pages') }}</li>
                        @foreach (Auth::user()->places()->take(4)->get() as $place)
                            <li><a href="{{ $place->url }}">{{ $place->text('name') }}</a></li>
                        @endforeach
                        <li role="separator" class="divider"></li>
                    @endif
                    <li><a href="{{ url('setting/page') }}">{{ trans('common.pages') }}</a></li>
                    <li><a href="{{ url('trash') }}">
                        {{ trans('common.deleted_pages') }}
                        <span class="badge">{{ Auth::user()->trash_count }}</span>
                    </a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="{{ Auth::user()->url }}">{{ trans('common.profile') }}</a></li>
                    <li><a href="{{ url('setting') }}">{{ trans('common.settings') }}</a></li>
                    <li><a href="{{ url('logout') }}">{{ trans('common.logout') }}</a></li>
                </ul>
            </li>
        @endif
    </ul>
</nav>
<div class="custom-navbar-space"></div>
