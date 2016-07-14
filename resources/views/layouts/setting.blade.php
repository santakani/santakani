@extends('layouts.app', [
    'title' => $title . ' - ' . trans('common.settings'),
    'body_classes' => isset($body_classes)?array_merge($body_classes, ['setting-page', 'setting-layout']):['setting-page', 'setting-layout'],
    'active_nav' => 'user',
])
<?php

$sections = [
    'profile' => ['name' => trans('common.profile'), 'url' => '/setting/profile'],
    'account' => ['name' => trans('common.account'), 'url' => '/setting/account'],
    'page' => ['name' => trans('common.my_pages'), 'url' => '/setting/page'],
    'story' => ['name' => trans('story.my_stories'), 'url' => '/setting/story'],
    //'trash' => ['name' => trans('common.trashed'), 'url' => '/setting/trash'],
];

?>
@section('main')
<div class="container">
    <div class="row">
        <div class="col-sm-4 col-md-3 col-lg-2">
            <ul class="nav nav-pills nav-stacked">
                @foreach ($sections as $key => $section)
                    <li  class="{{ $key === $active_section?'active':'' }}">
                        <a href="{{ $section['url'] }}">
                            {{ $section['name'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div><!-- .col -->
        <div class="col-sm-8 col-md-9 col-lg-8">
            @yield('setting_body')
        </div><!-- .col -->
    </div><!-- .row -->
</div><!-- .container -->
@endsection
