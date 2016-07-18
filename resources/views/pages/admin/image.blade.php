@extends('layouts.app', [
    'title' => 'Image management - Admin panel',
    'body_id' => 'image-admin-page',
    'body_classes' => ['image-admin-page', 'admin-page'],
])

@section('main')
    <div class="container">
        <br>
        <br>

        <ol class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li><a href="/admin">Admin panel</a></li>
            <li>Image management</li>
        </ol>

        <h1 class="page-header">Image management</h1>

        <ul class="nav nav-tabs">
            <li role="presentation" class="active"><a href="#">All</a></li>
            <li role="presentation"><a href="/admin/image/deleted">Deleted</a></li>
            <li role="presentation"><a href="/admin/image/nouse">No Use</a></li>
        </ul>

        <br>

        <table id="image-table" class="table">
            <tr>
                <th>ID</th>
                <th>Thumbnail</th>
                <th>Size</th>
                <th>User</th>
                <th>Parent</th>
                <th>Upload time</th>
            </tr>
            @foreach($images as $image)
                <tr data-model="{{ $image->toJSON() }}">
                    <td>{{ $image->id }}</td>
                    <td><img src="{{ $image->url('thumb') }}" width="150" height="150"></td>
                    <td>{{ $image->width }}x{{ $image->height }}</td>
                    <td>
                        @if (count($image->user))
                            {{ $image->user->name }} #{{ $image->user->id }}
                        @endif
                    </td>
                    <td>
                        @if (count($image->parent))
                            <a href="{{ $image->parent->url }}">
                                @if ($image->parent_type === 'story')
                                    {{ $image->parent->text('title') }}
                                @else
                                    {{ $image->parent->text('name') }}
                                @endif
                            </a>
                        @endif
                    </td>
                    <td>{{ $image->created_at }}</td>
                </tr>
            @endforeach
        </table>

        <div class="text-center">
            {!! $images->appends(request()->all())->links() !!}
        </div>
    </div>
@endsection
