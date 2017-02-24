@extends('layouts.app', [
    'title' => trans('common.edit') . ': ' . $designer->text('name') . ' - ' . trans('designer.designer'),
    'body_id' => 'designer-edit-page',
    'body_classes' => ['designer-edit-page', 'edit-page', 'designer-page'],
    'active_nav' => 'designer',
])

@section('header')
    <div class="container">
        <h1 class="page-header">{{ trans('common.edit') }}: {{ $designer->text('name') }}</h1>
    </div>
@endsection

@section('main')
    <div class="container">
        <form id="edit-form" class="edit-form form" action="{{ $designer->url }}" data-id="{{ $designer->id }}">

            <input type="hidden" name="_token" value="{{ csrf_token() }}">

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
                            More <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right"></ul>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    @foreach (App\Localization\Languages::all() as $locale)
                        <?php $translation = $designer->translations()->where('locale', $locale)->first(); ?>
                        <div id="translation-{{ $locale }}" class="tab-pane {{ $locale==='en'?'active':'' }}">
                            <div class="form-group">
                                <label>{{ trans('common.name') }}</label>
                                <input name="translations[{{ $locale }}][name]"
                                    value="{{ $translation->name or '' }}"
                                    class="form-control" type="text" maxlength="255">
                            </div>

                            <div class="form-group">
                                <label>{{ trans('designer.design_philosophy') }}</label>
                                <input name="translations[{{ $locale }}][tagline]"
                                    value="{{ $translation->tagline or '' }}"
                                    class="form-control" type="text" maxlength="255">
                            </div>

                            <div class="form-group">
                                <label>{{ trans('common.about') }}</label>
                                <p class="text-muted">{{ trans('designer.designer_about_tips') }}</p>
                                <textarea name="translations[{{ $locale }}][content]"
                                    class="content-editor">{{ $translation->content or '' }}</textarea>
                            </div>
                        </div>
                    @endforeach
                </div><!-- /.tab-content -->
            </div><!-- /.tab-pane -->

            <br/>

            <div class="form-group">
                <label>{{ trans('image.cover_image') }}</label>
                @include('components.upload.image-chooser', [
                    'id' => 'cover-chooser',
                    'image' => $designer->image,
                    'name' => 'image_id',
                    'width' => 600,
                    'height' => 200,
                    'size' => 'medium',
                ])
            </div>

            <div class="form-group">
                <label>{{ trans('common.logo') }} / {{ trans('designer.designer_photo') }}</label>
                @include('components.upload.image-chooser', [
                    'id' => 'logo-chooser',
                    'image' => $designer->logo,
                    'name' => 'logo_id',
                ])
            </div>

            <div class="form-group">
                <label>{{ trans('common.gallery') }}</label>
                <p class="text-muted">{{ trans('designer.designer_gallery_tips') }}</p>
                @include('components.upload.gallery-editor', [
                    'id' => 'gallery-editor',
                    'images' => $designer->gallery_images,
                ])
            </div>

            <div class="form-group">
                <label>{{ trans('geo.city') }}</label>
                @include('components.selects.city-select', ['selected' => $designer->city_id])
            </div>

            <div class="form-group">
                <label>{{ trans('common.tags') }}</label>
                @include('components.selects.tag-select', ['selected' => $designer->tags])
            </div>

            <div class="form-group">
                <label>{{ trans('common.email') }}</label>
                <input name="email" value="{{ $designer->email }}" type="email"
                    maxlength="255" class="form-control">
            </div>

            <div class="form-group">
                <label>{{ trans('common.website') }}</label>
                <input name="website" value="{{ $designer->website }}" type="url"
                    maxlength="255" class="form-control">
            </div>

            <div class="form-group">
                <label>Facebook</label>
                <input name="facebook" value="{{ $designer->facebook }}" type="url"
                    maxlength="255" class="form-control">
            </div>

            <div class="form-group">
                <label>Instagram</label>
                <input name="instagram" value="{{ $designer->instagram }}" type="url"
                    maxlength="255" class="form-control">
            </div>

            <div class="form-group">
                <label>Pinterest</label>
                <input name="pinterest" value="{{ $designer->pinterest }}" type="url"
                    maxlength="255" class="form-control">
            </div>

            <div class="form-group">
                <label>YouTube</label>
                <input name="youtube" value="{{ $designer->youtube }}" type="url"
                    maxlength="255" class="form-control">
            </div>

            <div class="form-group">
                <label>Vimeo</label>
                <input name="vimeo" value="{{ $designer->vimeo }}" type="url"
                    maxlength="255" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">{{ trans('common.save') }}</button>

            <a class="btn btn-link" href="{{ $designer->url }}">{{ trans('common.cancel') }}</a>

        </form>
    </div><!-- .container -->
@endsection

@push('templates')
    @include('templates.image-preview')
@endpush

@push('modals')
    @include('components.upload.image-manager')
@endpush
