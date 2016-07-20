@extends('layouts.setting', [
    'title' => trans('common.my_pages'),
    'body_id' => 'page-setting-page',
    'body_classes' => ['page-setting-page'],
    'active_section' => 'page',
])

@section('setting_body')

    <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading">{{ trans('designer.designer_pages') }}</div>
        <div class="panel-body">
        <p>{{ trans('designer.designer_pages_description') }}</p>
        </div>

        <!-- Table -->
        <table class="table">
            <tr>
                <th>{{ trans('common.logo') }}</th>
                <th>{{ trans('common.name') }}</th>
                <th>{{ trans('common.edit') }}</th>
            </tr>
            @foreach ($user->designers as $designer)
                <tr>
                    <td>
                        @if ($designer->logo_id)
                            <img src="{{ $designer->logo->url('thumb') }}" width="100" height="100"/>
                        @endif
                    </td>
                    <td><a href="/designer/{{ $designer->id }}">{{ $designer->text('name') }}</a></td>
                    <td><a href="/designer/{{ $designer->id }}/edit">{{ trans('common.edit') }}</a></td>
                </tr>
            @endforeach
        </table>
    </div>

    <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading">{{ trans('place.place_pages') }}</div>
        <div class="panel-body">
        <p>{{ trans('place.my_place_pages_description') }}</p>
        </div>

        <!-- Table -->
        <table class="table">
            <tr>
                <th>{{ trans('image.cover_image') }}</th>
                <th>{{ trans('common.name') }}</th>
                <th>{{ trans('geo.address') }}</th>
                <th>{{ trans('geo.city') }}</th>
                <th>{{ trans('common.edit') }}</th>
            </tr>
            @foreach ($user->places as $place)
                <tr>
                    <td>
                        @if ($place->image_id)
                            <img src="{{ $place->image->url('thumb') }}" width="100" height="100"/>
                        @endif
                    </td>
                    <td><a href="/place/{{ $place->id }}">{{ $place->text('name') }}</a></td>
                    <td>{{ $place->address }}</td>
                    <td>{{ $place->city->full_name }}</td>
                    <td><a href="/place/{{ $place->id }}/edit">{{ trans('common.edit') }}</a></td>
                </tr>
            @endforeach
        </table>
    </div>

@endsection
