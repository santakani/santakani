@extends('layouts.app', [
    'title' => $title . ' - ' . trans('common.settings'),
    'body_classes' => isset($body_classes)?array_merge($body_classes, ['setting-page', 'setting-layout']):['setting-page', 'setting-layout'],
    'active_nav' => 'user',
])

@section('main')

<div class="container">
    <div class="row">
        <div class="col-sm-3 col-md-2">
            <ul class="nav nav-pills nav-stacked">
                <li class="{{ $active_section === 'profile'?'active':'' }}">
                    <a href="{{ url('settings/profile') }}">
                        {{ trans('common.profile') }}
                    </a>
                </li>
                <li class="{{ $active_section === 'account'?'active':'' }}">
                    <a href="{{ url('settings/account') }}">
                        {{ trans('common.account') }}
                    </a>
                </li>
                <li class="{{ $active_section === 'password'?'active':'' }}">
                    <a href="{{ url('settings/password') }}">
                        {{ trans('common.password') }}
                    </a>
                </li>
                <li class="{{ $active_section === 'address'?'active':'' }}">
                    <a href="{{ url('settings/address') }}">
                        {{ trans('geo.address') }}
                    </a>
                </li>
                <li class="{{ $active_section === 'pages'?'active':'' }}">
                    <a href="{{ url('settings/pages') }}">
                        {{ trans('common.pages') }}
                    </a>
                </li>
                <li class="{{ $active_section === 'designs'?'active':'' }}">
                    <a href="{{ url('settings/designs') }}">
                        {{ trans('design.designs') }}
                    </a>
                </li>
                <li class="{{ $active_section === 'stories'?'active':'' }}">
                    <a href="{{ url('settings/stories') }}">
                        {{ trans('story.stories') }}
                    </a>
                </li>
            </ul>
        </div><!-- .col -->
        <div class="col-sm-9 col-md-8 col-lg-6 col-lg-offset-1">
            @yield('setting_body')
        </div><!-- .col -->
    </div><!-- .row -->
</div><!-- .container -->

@endsection
