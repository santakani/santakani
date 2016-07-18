@extends('layouts.app', [
    'title' => 'Deleted users - Admin panel',
    'body_id' => 'deleted-user-admin-page',
    'body_classes' => ['deleted-user-admin-page', 'admin-page'],
])

@section('main')
    <div class="container">
        <br>
        <br>

        <ol class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li><a href="/admin">Admin panel</a></li>
            <li><a href="/admin/user">User management</a></li>
            <li>Deleted users</li>
        </ol>

        <h1 class="page-header">Deleted users</h1>

        <form class="form-inline" action="/admin/user" method="get">
            <div class="form-group">
                <label class="control-label">Name</label>
                <input name="name" value="{{ request()->input('name') }}" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label class="control-label">Email</label>
                <input name="email" value="{{ request()->input('email') }}" type="text" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
        </form>

        <br>

        <table id="user-table" class="table">
            <tr>
                <th>ID</th>
                <th>Avatar</th>
                <th>Name</th>
                <th>Email</th>
                <th>Register time</th>
                <th>Delete time</th>
                <th>Action</th>
            </tr>
            @foreach($users as $user)
                <tr data-model="{{ $user->toJSON() }}">
                    <td>{{ $user->id }}</td>
                    <td><img src="{{ $user->avatar('small') }}" width="50" height="50"></td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td>{{ $user->deleted_at }}</td>
                    <td>
                        @if (Auth::user()->can('delete-user', $user))
                            <button type="button" class="restore-button btn btn-success">Restore</button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>

        <div class="text-center">
            {!! $users->appends(request()->all())->links() !!}
        </div>
    </div>
@endsection
