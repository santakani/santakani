@extends('layouts.app', [
    'title' => trans('common.edit').': '.$place->text('name').' - '.trans('place.place'),
    'body_id' => 'place-edit-page',
    'body_classes' => ['place-edit-page', 'place-page', 'edit-page'],
    'active_nav' => 'place',
])

@section('main')

    <form class="edit-form" action="{{ $place->url }}" data-id="{{ $place->id }}">
        <div class="container">

            {!! csrf_field() !!}

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
                        <?php $translation = $place->translations()->where('locale', $locale)->first(); ?>
                        <div id="translation-{{ $locale }}" class="tab-pane {{ $locale==='en'?'active':'' }}">
                            <div class="form-group">
                                <label class="control-label">Name</label>
                                <input name="translations[{{ $locale }}][name]"
                                    value="{{ $translation->name or '' }}"
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

            <div class="form-group">
                <label class="control-label">Type</label>
                @include('components.place-type-select', [
                    'selected' => $place->type,
                    'required' => true,
                ])
            </div>

            <div class="form-group">
                <label class="control-label">Cover image</label>
                <div id="cover-chooser" class="image-chooser"
                    data-id="{{ $place->image_id }}"
                    data-mime="{{ $place->image->mime_type or '' }}"
                    data-width="{{ $place->image->width or '' }}"
                    data-height="{{ $place->image->height or '' }}"></div>
            </div>

            <div class="form-group">
                <label class="control-label">Gallery</label>
                <div id="gallery-editor" class="gallery-editor">
                    <p><button type="button" class="btn btn-default"><i class="fa fa-picture-o"></i> Choose</button></p>
                    <div class="images clearfix">
                        @foreach ($place->gallery_images as $image)
                            @include('components.image-preview', ['image' => $image])
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label">City</label>
                <select name="city_id" id="city-select" class="city-select form-control">
                    @if (!empty($place->city_id))
                        <option value="{{ $place->city_id }}" selected="selected">
                            {{ $place->city->text('name') }}, {{ $place->country->text('name') }}
                        </option>
                    @endif
                </select>
            </div>

            <div class="form-group">
                <label class="control-label">Address</label>
                <input name="address" value="{{ $place->address }}" type="text"
                    maxlength="255" class="form-control" id="address-input">
                <button id="search-coordinate-button" class="btn btn-info" type="button">
                    <i class="fa fa-map-marker fa-lg"></i> Mark On Map
                </button>
            </div>

            <div class="form-group">
                @include('components.coordinate-select', [
                    'latitude' => $place->latitude,
                    'longitude' => $place->longitude,
                ])
            </div>

            <div class="form-group">
                <label class="control-label">Tags</label>
                <select name="tag_ids[]" class="tag-select" style="width: 100%" multiple="multiple">
                    @foreach ($place->tags as $tag)
                        <option value="{{ $tag->id }}" selected="selected">
                            {{ $tag->text('name') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="control-label">Phone</label>
                <input name="phone" value="{{ $place->phone }}" type="tel"
                    id="phone-input" class="form-control" maxlength="255">
            </div>

            <div class="form-group">
                <label class="control-label">Email</label>
                <input name="email" value="{{ $place->email }}" type="email"
                    maxlength="255" class="form-control" id="input-email">
            </div>

            <div class="form-group">
                <label class="control-label">Website</label>
                <input name="website" value="{{ $place->website }}" type="url"
                    maxlength="255" class="form-control" id="input-website">
            </div>

            <div class="form-group">
                <label class="control-label">Facebook</label>
                <input name="facebook" value="{{ $place->facebook }}" type="url"
                    maxlength="255" class="form-control" id="input-facebook">
            </div>

            <div class="form-group">
                <label class="control-label">Google+</label>
                <input name="google_plus" value="{{ $place->google_plus }}" type="url"
                    maxlength="255" class="form-control" id="input-google-plus">
            </div>

            <button type="submit" class="btn btn-primary">Save</button>

        </div><!-- /.container -->
    </form>
@endsection

@push('templates')
    @include('templates.image-preview')
@endpush

@push('modals')
    @include('components.image-manager')
@endpush
