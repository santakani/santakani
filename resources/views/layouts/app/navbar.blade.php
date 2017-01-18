<?php isset($active_nav) || $active_nav = null; ?>

<nav class="custom-navbar">
    <ul class="nav-menu">
        <li class="brand hidden-xs">
            <a href="{{ url('/') }}">
                <svg class="icon"><use xlink:href="/svg/sprites.svg#santakani"/></svg>
                <span class="text">{{ trans('brand.name') }}</span>
            </a>
        </li>
        <li class="{{ $active_nav === 'design'?'active':'' }}">
            <a href="{{ url('/') }}">
                <svg class="icon"><use xlink:href="/svg/sprites.svg#design"/></svg>
                <span class="text">{{ trans('design.design') }}</span>
            </a>
        </li>
        <li class="{{ $active_nav === 'place'?'active':'' }}">
            <a href="{{ url('place') }}">
                <svg class="icon"><use xlink:href="/svg/sprites.svg#map"/></svg>
                <span class="text">{{ trans('geo.map') }}</span>
            </a>
        </li>
        <li class="{{ $active_nav === 'story'?'active':'' }}">
            <a href="{{ url('story') }}">
                <svg class="icon"><use xlink:href="/svg/sprites.svg#story"/></svg>
                <span class="text">{{ trans('story.story') }}</span>
            </a>
        </li>

        <li class="space"></li>

        @if (Auth::guest())
            <li class="{{ $active_nav === 'login'?'active':'' }}">
                <a href="{{ app_redirect_url('login') }}">
                    <svg class="icon"><use xlink:href="/svg/sprites.svg#login"/></svg>
                    <span class="text">{{ trans('common.login') }}</span>
                </a>
            </li>
            <li class="hidden-xs {{ $active_nav === 'register'?'active':'' }}">
                <a href="{{ app_redirect_url('register') }}">
                    <svg class="icon"><use xlink:href="/svg/sprites.svg#register"/></svg>
                    <span class="text">{{ trans('common.register') }}</span>
                </a>
            </li>
        @else
            <li class="dropdown hidden-xs">
                <a href="#" class="create dropdown-toggle" data-toggle="dropdown">
                    <svg class="icon"><use xlink:href="/svg/sprites.svg#create"/></svg>
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
