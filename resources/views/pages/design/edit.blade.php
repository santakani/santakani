@extends('layouts.app', [
    'title' => trans('common.edit') . ': ' . $design->text('name') . ' - ' . trans('design.design'),
    'body_id' => 'design-edit-page',
    'body_classes' => ['design-edit-page', 'edit-page', 'design-page'],
    'active_nav' => 'design',
])

@section('header')
    <div class="container">
        <h1 class="page-header">{{ trans('common.edit') }}: {{ $design->text('name') }}</h1>
    </div>
@endsection

@section('main')
    <div class="container">
        <form id="edit-form" class="edit-form" action="{{ $design->url }}" data-id="{{ $design->id }}" data-type="design">

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
                            More <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right"></ul>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    @foreach (App\Localization\Languages::all() as $locale)
                        <?php $translation = $design->translations()->where('locale', $locale)->first(); ?>
                        <div id="translation-{{ $locale }}" class="tab-pane {{ $locale==='en'?'active':'' }}">
                            <div class="form-group">
                                <label>{{ trans('common.name') }}</label>
                                <input name="translations[{{ $locale }}][name]"
                                    value="{{ $translation->name or '' }}"
                                    class="form-control" type="text" maxlength="255">
                            </div>

                            <div class="form-group">
                                <label>{{ trans('common.description') }}</label>
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
                    'image' => $design->image,
                    'name' => 'image_id',
                ])
            </div>

            <div class="form-group">
                <label>{{ trans('common.gallery') }}</label>
                @include('components.upload.gallery-editor', [
                    'id' => 'gallery-editor',
                    'images' => $design->gallery_images,
                ])
            </div>

            <div class="form-group">
                <label>{{ trans('common.tags') }}</label>
                @include('components.selects.tag-select', ['selected' => $design->tags])
            </div>

            <div class="form-group">
                <label>{{ trans('design.price') }}</label>
                <div class="row">
                    <div class="col-xs-6">
                        <input name="price" value="{{ $design->price }}" type="text"
                            maxlength="255" class="form-control">
                    </div>
                    <div class="col-xs-6">
                        @include('components.selects.currency-select', ['selected' => $design->currency])
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>{{ trans('design.webshop_link') }}</label>
                <input name="webshop" value="{{ $design->webshop }}" type="url"
                    maxlength="255" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">{{ trans('common.save') }}</button>

            <a class="btn btn-link" href="{{ $design->url }}">{{ trans('common.cancel') }}</a>

        </form>
    </div><!-- .container -->
@endsection

@push('templates')
    @include('templates.image-preview')
@endpush

@push('modals')
    @include('components.upload.image-manager')
@endpush
