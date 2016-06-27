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
        <form class="edit-form form" action="{{ $designer->url }}"
            data-id="{{ $designer->id }}">

            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="tab-pane-group">
                <!-- Nav tabs -->
                <ul id="translation-tabs" class="nav nav-tabs">
                    @foreach (App\Localization\Languages::getLanguageList() as $locale => $names)
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
                    @foreach (App\Localization\Languages::getLanguageCodeList() as $locale)
                        <?php $translation = $designer->translations()->where('locale', $locale)->first(); ?>
                        <div id="translation-{{ $locale }}" class="tab-pane {{ $locale==='en'?'active':'' }}">
                            <div class="form-group">
                                <label class="control-label">Name</label>
                                <input name="translations[{{ $locale }}][name]"
                                    value="{{ $translation->name or '' }}"
                                    class="form-control" type="text" maxlength="255">
                            </div>

                            <div class="form-group">
                                <label class="control-label">Tagline</label>
                                <input name="translations[{{ $locale }}][tagline]"
                                    value="{{ $translation->tagline or '' }}"
                                    class="form-control" type="text" maxlength="255">
                            </div>

                            <div class="form-group">
                                <label class="control-label">Content</label>
                                <textarea name="translations[{{ $locale }}][content]"
                                    class="content-editor">{{ $translation->content or '' }}</textarea>
                            </div>
                        </div>
                    @endforeach
                </div><!-- /.tab-content -->
            </div><!-- /.tab-pane -->

            <br/>

            <div id="image-form-group" class="form-group">
                <label class="control-label">Cover image</label>
                <div id="cover-editor" class="cover-editor">
                    <p><button type="button" class="btn btn-default"><i class="fa fa-picture-o"></i> Choose</button></p>
                    @if ($designer->image_id)
                        @include('components.image-preview', ['image' => $designer->image])
                    @else
                        @include('components.image-preview')
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label class="control-label">Gallery</label>
                <div id="gallery-editor" class="gallery-editor">
                    <p><button type="button" class="btn btn-default"><i class="fa fa-picture-o"></i> Choose</button></p>
                    <div class="images clearfix">
                        @foreach ($designer->gallery_images as $image)
                            @include('components.image-preview', ['image' => $image])
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label">City</label>
                <select name="city_id" id="city-select" class="city-select form-control">
                    @if (!empty($designer->city_id))
                        <option value="{{ $designer->city_id }}" selected="selected">{{ $designer->city->full_name }}</option>
                    @endif
                </select>
            </div>

            <div class="form-group">
                <label class="control-label">Tags</label>
                <select name="tag_ids[]" class="tag-select" style="width: 100%" multiple="multiple">
                    @foreach ($designer->tags as $tag)
                        <option value="{{ $tag->id }}" selected="selected">{{ $tag->text('name') }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="control-label">Email</label>
                <input name="email" value="{{ $designer->email }}" type="email"
                    maxlength="255" class="form-control">
            </div>

            <div class="form-group">
                <label class="control-label">Website</label>
                <input name="website" value="{{ $designer->website }}" type="url"
                    maxlength="255" class="form-control">
            </div>

            <div class="form-group">
                <label class="control-label">Facebook</label>
                <input name="facebook" value="{{ $designer->facebook }}" type="url"
                    maxlength="255" class="form-control">
            </div>

            <div class="form-group">
                <label class="control-label">Twitter</label>
                <input name="twitter" value="{{ $designer->twitter }}" type="url"
                    maxlength="255" class="form-control">
            </div>

            <div class="form-group">
                <label class="control-label">Google+</label>
                <input name="google_plus" value="{{ $designer->google_plus }}" type="url"
                    maxlength="255" class="form-control">
            </div>

            <div class="form-group">
                <label class="control-label">Instagram</label>
                <input name="instagram" value="{{ $designer->instagram }}" type="url"
                    maxlength="255" class="form-control">
            </div>

            <button type="submit" class="btn btn-default">Save</button>

        </form>
    </div><!-- .container -->
@endsection

@push('templates')
    @include('templates.image-preview')
@endpush

@push('modals')
    @include('components.image-manager')
@endpush
