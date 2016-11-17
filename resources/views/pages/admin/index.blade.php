@extends('layouts.app', [
    'title' => 'Admin panel',
    'body_id' => 'admin-page',
    'body_classes' => ['admin-page'],
])

@section('main')
    <div class="container">
        <br>
        <br>

        <ol class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li>Admin</li>
        </ol>

        <br>
        <br>

        <div class="list-group">
            <a href="/admin/log/activity" class="list-group-item"><i class="fa fa-fw fa-calendar"></i> Activity Log</a>
            <a href="/admin/user" class="list-group-item"><i class="fa fa-fw fa-users"></i> Users</a>
            <a href="/admin/image" class="list-group-item"><i class="fa fa-fw fa-image"></i> Images</a>
            <a href="/admin/like" class="list-group-item"><i class="fa fa-fw fa-heart"></i> Likes</a>
            <a href="/admin/comment" class="list-group-item"><i class="fa fa-fw fa-comment"></i> Comments</a>
        </div>
    </div>
@endsection
