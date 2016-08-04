@extends('layouts.setting', [
    'title' => trans('story.my_stories'),
    'body_id' => 'story-setting-page',
    'body_classes' => ['story-setting-page'],
    'active_section' => 'story',
])

@section('setting_body')

    <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading">{{ trans('story.stories') }}</div>

        <!-- Table -->
        <table class="table">
            <tr>
                <th>{{ trans('image.cover_image') }}</th>
                <th>{{ trans('common.name') }}</th>
                <th>{{ trans('common.create_time') }}</th>
                <th>{{ trans('common.update_time') }}</th>
                <th>{{ trans('common.edit') }}</th>
            </tr>
            @foreach ($user->stories as $story)
                <tr>
                    <td>
                        @if ($story->image_id)
                            <img src="{{ $story->image->fileUrl('thumb') }}" width="100" height="100"/>
                        @endif
                    </td>
                    <td><a href="/story/{{ $story->id }}">{{ $story->text('title') }}</a></td>
                    <td>{{ $story->created_at }}</td>
                    <td>{{ $story->updated_at }}</td>
                    <td><a href="/story/{{ $story->id }}/edit">{{ trans('common.edit') }}</a></td>
                </tr>
            @endforeach
        </table>
    </div>

@endsection
