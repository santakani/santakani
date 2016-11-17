@extends('layouts.app', [
    'title' => 'Activity log - Admin panel',
    'body_id' => 'activity-log-admin-page',
    'body_classes' => ['activity-log-admin-page', 'admin-page'],
])

@section('main')
    <div class="container">
        <br>
        <br>

        <ol class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li><a href="/admin">Admin panel</a></li>
            <li>Activity log</li>
        </ol>

        <h1 class="page-header">Activity log</h1>

        <br>

        <table id="image-table" class="table">
            <tr>
                <th>Time</th>
                <th>Action</th>
                <th>Message</th>
            </tr>
            @foreach($activity_logs as $activity_log)
                <tr data-model="{{ $activity_log->toJSON() }}">
                    <td>{{ $activity_log->created_at }}</td>
                    <td>{{ $activity_log->action }}</td>
                    <td>{!! $activity_log->message !!}</td>
                </tr>
            @endforeach
        </table>

        <div class="text-center">
            {!! $activity_logs->appends(request()->all())->links() !!}
        </div>
    </div>
@endsection
