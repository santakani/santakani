@extends('layouts.app', [
    'title' => trans('common.edit').': '.$place->text('name').' - '.trans('place.place'),
    'body_id' => 'place-edit-page',
    'body_classes' => ['place-edit-page', 'place-page', 'edit-page'],
    'active_nav' => 'place',
])

@section('header')
    <div class="container">
        <h1 class="page-header">{{ trans('common.edit') }}: {{ $place->text('name') }}</h1>
    </div>
@endsection

@section('main')

    <form id="edit-form" class="edit-form" action="{{ $place->url }}" data-id="{{ $place->id }}">
        <div class="container">

            {!! csrf_field() !!}

            <div class="tab-pane-group">
                <!-- Nav tabs -->
                <ul id="translation-tabs" class="nav nav-tabs">
                    @foreach (App\Localization\Languages::names() as $locale => $names)
                        <li class="{{ $locale==='en'?'active':'' }}">
                            <a href="#translation-{{ $locale }}" data-toggle="tab" title="{{ $names['native'] }}">
                                {{ $names['localized'] }}
                            </a>
                        </li>
                    @endforeach
                    <li class="more dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            {{ trans('common.more') }} <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right"></ul>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    @foreach (App\Localization\Languages::all() as $locale)
                        <?php $translation = $place->translations()->where('locale', $locale)->first(); ?>
                        <div id="translation-{{ $locale }}" class="tab-pane {{ $locale==='en'?'active':'' }}">
                            <div class="form-group">
                                <label class="control-label">{{ trans('common.name') }}</label>
                                <input name="translations[{{ $locale }}][name]"
                                    value="{{ $translation->name or '' }}"
                                    class="form-control" type="text" maxlength="255">
                            </div>

                            <div class="form-group">
                                <label class="control-label">{{ trans('common.description') }}</label>
                                <textarea name="translations[{{ $locale }}][content]"
                                    class="content-editor">{{ $translation->content or '' }}</textarea>
                            </div>
                        </div>
                    @endforeach
                </div><!-- /.tab-content -->
            </div><!-- /.tab-pane -->

            <br/>

            <div class="form-group">
                <label class="control-label">{{ trans('common.type') }}</label>
                @include('components.place-type-select', [
                    'selected' => $place->type,
                    'required' => true,
                ])
            </div>

            <div class="form-group">
                <label class="control-label">{{ trans('image.cover_image') }}</label>
                @include('components.upload.image-chooser', ['id' => 'cover-chooser', 'image' => $place->image])
            </div>

            <div class="form-group">
                <label class="control-label">{{ trans('common.gallery') }}</label>
                @include('components.upload.gallery-editor', [
                    'id' => 'gallery-editor',
                    'images' => $place->gallery_images,
                ])
            </div>

            <div class="form-group">
                <label class="control-label">{{ trans('geo.city') }}</label>
                @include('components.selects.city-select', ['selected' => $place->city_id])
            </div>

            <div class="form-group">
                <label class="control-label">{{ trans('geo.address') }}</label>
                <input name="address" value="{{ $place->address }}" type="text"
                    maxlength="255" class="form-control" id="address-input">
            </div>

            <div class="form-group">
                <label class="control-label">{{ trans('geo.coordinate_select.label') }}</label>
                @include('components.coordinate-select', [
                    'latitude' => $place->latitude,
                    'longitude' => $place->longitude,
                ])
            </div>

            <div class="form-group">
                <label class="control-label">{{ trans('common.tags') }}</label>
                @include('components.selects.tag-select', ['selected' => $place->tags])
            </div>

            <div class="form-group">
                <label class="control-label">{{ trans('common.phone_number') }}</label>
                <input name="phone" value="{{ $place->phone }}" type="tel"
                    id="phone-input" class="form-control" maxlength="255">
            </div>

            <div class="form-group">
                <label class="control-label">{{ trans('common.email_address') }}</label>
                <input name="email" value="{{ $place->email }}" type="email"
                    maxlength="255" class="form-control" id="input-email">
            </div>

            <div class="form-group">
                <label class="control-label">{{ trans('common.website') }}</label>
                <input name="website" value="{{ $place->website }}" type="url"
                    maxlength="255" class="form-control" id="input-website">
            </div>

            <div class="form-group">
                <label class="control-label">Facebook</label>
                <input name="facebook" value="{{ $place->facebook }}" type="url"
                    maxlength="255" class="form-control" id="input-facebook">
            </div>

            <button type="submit" class="btn btn-primary">{{ trans('common.save') }}</button>

            <a class="btn btn-link" href="{{ $place->url }}">{{ trans('common.cancel') }}</a>

        </div><!-- /.container -->
    </form>
@endsection

@push('templates')
    @include('templates.image-preview')
@endpush

@push('modals')
    @include('components.upload.image-manager')
@endpush
