@extends('layout.app', [
    'body_class' => $body_class . ' setting-page',
    'active_nav' => 'user',
])
<?php

$sections = [
    'profile' => ['name' => 'Profile', 'url' => '/setting/profile'],
    'account' => ['name' => 'Account', 'url' => '/setting/account'],
    'page' => ['name' => 'Pages', 'url' => '/setting/page'],
    'trash' => ['name' => 'Trashed content', 'url' => '/setting/trash'],
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
