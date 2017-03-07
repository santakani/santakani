<?php isset($active_nav) || $active_nav = null; ?>

<nav class="navbar">

    <ul class="nav-menu">

        <!-- Logo -->
        <li class="hidden-xs">
            <a href="{{ url('/') }}">
                <img src="{{ url('img/logo/without-shadow.svg') }}" width="24" height="24">
                <span class="text">{{ trans('brand.name') }}</span>
            </a>
        </li>

        <!-- Flexible space for desktop navbar -->
        <li class="space">
            <form class="form-inline" action="{{ url('search') }}" method="get">
                <input class="form-control" type="search" name="query" placeholder="&#xf4a4; {{ trans('common.search') }}" required>
            </form>
        </li>

        <!-- Home/design icon -->
        <li class="{{ $active_nav === 'design'?'active':'' }}">
            <a href="{{ url('/') }}">
                <span class="icon ion-ios-home{{ $active_nav === 'design'?'':'-outline' }} visible-xs-block"></span>
                <span class="text">{{ trans('common.home') }}</span>
            </a>
        </li>

        <!-- Designer icon -->
        <li class="{{ $active_nav === 'designer'?'active':'' }}">
            <a href="{{ url('designer') }}">
                <span class="icon ion-ios-people{{ $active_nav === 'designer'?'':'-outline' }} visible-xs-block"></span>
                <span class="text">{{ trans('designer.designer') }}</span>
            </a>
        </li>

        <!-- Map/place icon -->
        <li class="{{ $active_nav === 'place'?'active':'' }}">
            <a href="{{ url('place') }}">
                <span class="icon ion-ios-location{{ $active_nav === 'place'?'':'-outline' }} visible-xs-block"></span>
                <span class="text">{{ trans('geo.map') }}</span>
            </a>
        </li>

        <!-- Story icon -->
        <li class="{{ $active_nav === 'story'?'active':'' }}">
            <a href="{{ url('story') }}">
                <span class="icon ion-ios-book{{ $active_nav === 'story'?'':'-outline' }} visible-xs-block"></span>
                <span class="text">{{ trans('story.story') }}</span>
            </a>
        </li>

        <li class="dropdown hidden-xs">
            <a href="#" class="create dropdown-toggle" data-toggle="dropdown" title="{{ trans('common.more') }}">
                <span class="icon ion-ios-more-outline"></span>
            </a>
            <ul class="dropdown-menu">
                <li><a href="{{ url('tag') }}">{{ trans('common.tag') }}</a></li>
                <li><a href="{{ url('about') }}">{{ trans('common.about_us') }}</a></li>
                <li><a href="{{ url('help') }}">{{ trans('common.help') }}</a></li>
            </ul>
        </li>

        <!-- Flexible space for desktop navbar -->
        <li class="space"></li>

        @if (Auth::guest())

            <!-- Login icon -->
            <li class="{{ $active_nav === 'login'?'active':'' }}">
                <a href="{{ app_redirect_url('login') }}">
                    <span class="icon ion-ios-person{{ $active_nav === 'login'?'':'-outline' }} visible-xs-block"></span>
                    <span class="text">{{ trans('common.login') }}</span>
                </a>
            </li>

        @else

            <!-- Create dropdown, only in desktop -->
            <li class="dropdown hidden-xs">
                <a href="#" class="create dropdown-toggle" data-toggle="dropdown" title="{{ trans('common.create') }}">
                    <span class="icon ion-ios-compose-outline"></span>
                    <span class="text">{{ trans('common.create') }}</span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="{{ url('/designer/create') }}">{{ trans('designer.designer') }}</a></li>
                    <li><a href="{{ url('/place/create') }}">{{ trans('place.place') }}</a></li>
                    <li><a href="{{ url('/story/create') }}">{{ trans('story.story') }}</a></li>
                    @if (Auth::user()->can('create-tag'))
                        <li><a href="{{ url('/tag/create') }}">{{ trans('common.tag') }}</a></li>
                    @endif
                </ul>
            </li>

            <!-- Mobile user icon -->
            <li class="visible-xs-block {{ $active_nav === 'user'?'active':'' }}">
                <a href="{{ Auth::user()->url }}">
                    <span class="icon ion-ios-person{{ $active_nav === 'user'?'':'-outline' }}"></span>
                    <span class="text">{{ trans('common.user') }}</span>
                </a>
            </li>

            <!-- Desktop user menu -->
            <li class="dropdown {{ $active_nav === 'user'?'active':'' }} hidden-xs">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <img class="avatar" src="{{ Auth::user()->avatar('medium') }}" />
                </a>
                <ul class="dropdown-menu dropdown-menu-right">
                    <li class="name"><a href="{{ Auth::user()->url }}">{{ Auth::user()->name }}</a></li>
                    <?php
                        $designer_count = Auth::user()->designers()->count();
                        $place_count = Auth::user()->places()->count();
                    ?>
                    @if ($designer_count)
                        <li class="dropdown-header">{{ trans('designer.designer_pages') }}</li>
                        @foreach (Auth::user()->designers()->take(4)->get() as $designer)
                            <li><a href="{{ $designer->url }}">{{ $designer->text('name') }}</a></li>
                        @endforeach
                    @endif
                    @if ($place_count)
                        <li class="dropdown-header">{{ trans('place.place_pages') }}</li>
                        @foreach (Auth::user()->places()->take(4)->get() as $place)
                            <li><a href="{{ $place->url }}">{{ $place->text('name') }}</a></li>
                        @endforeach
                    @endif
                    <li role="separator" class="divider"></li>
                    @if (Auth::user()->role === 'admin')
                        <li><a href="/admin">Admin panel</a></li>
                    @endif
                    <li><a href="{{ url('settings') }}">{{ trans('common.settings') }}</a></li>
                    <li><a class="logout-action" href="{{ url('logout') }}">{{ trans('common.logout') }}</a></li>
                </ul>
            </li>
        @endif
    </ul>
</nav>
