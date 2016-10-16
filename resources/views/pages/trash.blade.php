@extends('layouts.app', [
    'title' => trans('common.deleted_pages'),
    'body_id' => 'trash-page',
    'body_classes' => ['trash-page'],
    'active_nav' => 'user',
])

@section('main')
<div class="container">
    <h1 class="page-header">{{ trans('common.deleted_pages') }}</h1>
    <!-- Nav tabs -->
    <ul class="nav nav-tabs">
        <li class="{{ $type === 'design'?'active':'' }}">
            <a href="{{ url('trash/design') }}">{{ trans('design.designs') }}</a>
        </li>
        <li class="{{ $type === 'designer'?'active':'' }}">
            <a href="{{ url('trash/designer') }}">{{ trans('designer.designers') }}</a>
        </li>
        <li class="{{ $type === 'place'?'active':'' }}">
            <a href="{{ url('trash/place') }}">{{ trans('place.places') }}</a>
        </li>
        <li class="{{ $type === 'story'?'active':'' }}">
            <a href="{{ url('trash/story') }}">{{ trans('story.stories') }}</a>
        </li>
    </ul>

    <br/><br/>

    <!-- Table -->
    <table class="table">
        <tr>
            <th>{{ trans('image.cover_image') }}</th>
            <th>{{ trans('common.name') }}</th>
            <th>{{ trans('common.delete_time') }}</th>
            <th>{{ trans('common.action') }}</th>
        </tr>
        @foreach ($pages as $page)
            <tr data-url="{{ $page->url }}">
                <td>
                    @if (count($page->image))
                        <img src="{{ $page->image->fileUrl('thumb') }}" width="100" height="100"/>
                    @endif
                </td>
                <td>{{ $type === 'story' ? $page->title : $page->name }}</td>
                <td>{{ $page->deleted_at }}</td>
                <td>
                    <button class="restore-button btn btn-sm btn-success">{{ trans('common.restore') }}</button>
                    <button class="delete-button btn btn-sm btn-danger">{{ trans('common.delete') }}</button>
                </td>
            </tr>
        @endforeach
    </table>
</div><!-- /.container -->
@endsection
