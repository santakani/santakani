@extends('layouts.app', [
    'title' => trans('common.edit') . ' ' . $designer->text('name'),
    'body_id' => 'designer-edit-page',
    'body_classes' => ['designer-edit-page', 'edit-page', 'designer-page'],
    'active_nav' => 'designer',
])

@section('main')

<div class="container">

    <h1>{{ trans('common.edit') }} <a href="{{ $designer->url }}">{{ $designer->text('name') }}</a></h1>

    <form id="designer-edit-form" class="edit-form" action="{{ $designer->url }}" data-id="{{ $designer->id }}">

        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <fieldset class="scheduler-border">
            <legend class="scheduler-border">{{ trans('common.description') }}</legend>

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

        </fieldset>

        <br/>

        <fieldset class="scheduler-border">
            <legend class="scheduler-border">{{ trans('common.images') }}</legend>

            <div class="form-group">
                <label>{{ trans('image.cover_image') }}</label>
                @include('components.upload.image-chooser', [
                    'id' => 'cover-chooser',
                    'image' => $designer->image,
                    'name' => 'image_id',
                    'width' => 600,
                    'height' => 300,
                    'size' => 'banner',
                ])
                <p class="text-muted">{{ trans('image.recommended_size', ['width' => 600, 'height' => 300]) }}
            </div>

            <div class="form-group">
                <label>{{ trans('common.logo') }}</label>
                @include('components.upload.image-chooser', [
                    'id' => 'logo-chooser',
                    'image' => $designer->logo,
                    'name' => 'logo_id',
                    'width' => 300,
                    'height' => 300,
                    'size' => 'thumb',
                ])
                <p class="text-muted">{{ trans('image.recommended_size', ['width' => 300, 'height' => 300]) }}
            </div>

            <div class="form-group">
                <label>{{ trans('common.gallery') }}</label>
                <p class="text-muted">{{ trans('designer.designer_gallery_tips') }}</p>
                @include('components.upload.gallery-editor', [
                    'id' => 'gallery-editor',
                    'images' => $designer->gallery_images,
                ])
            </div>

        </fieldset>

        <fieldset class="scheduler-border">
            <legend class="scheduler-border">{{ trans('common.information') }}</legend>

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

        </fieldset>

        <fieldset class="scheduler-border">
            <legend class="scheduler-border">{{ trans('common.links') }}</legend>
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
        </fieldset>


        <fieldset class="scheduler-border">
            <legend class="scheduler-border">{{ trans('ecommerce.shipment_vat') }}</legend>

            <div class="form-group">
                <label>{{ trans('ecommerce.vat_rate') }} (EU)</label>
                <input name="vat_rate" value="{{ $designer->vat_rate }}" type="number"
                    min="0.00" max="1.00" step="0.01" class="form-control" placeholder="{{ trans('ecommerce.vat_rate_tip') }}">
            </div>

            @if ($designer->city_id)
                <div class="form-group">
                    <label>{{ trans('ecommerce.shipment') }} ({{ $designer->city->country->name }})</label>
                    <div class="input-group">
                        <input name="national_shipment" value="{{ $designer->national_shipment }}" type="number"
                            min="0.00" max="999.99" step="1" class="form-control">
                            <span class="input-group-addon" id="sizing-addon2">&euro; EUR</span>
                    </div><!-- /.input-group -->
                </div><!-- /.form-group -->

                <div class="form-group">
                    <label>{{ trans('ecommerce.shipment') }} ({{ $designer->city->country->continent_name }})</label>
                    <div class="input-group">
                        <input name="regional_shipment" value="{{ $designer->regional_shipment }}" type="number"
                            min="0.00" max="999.99" step="1" class="form-control">
                            <span class="input-group-addon" id="sizing-addon2">&euro; EUR</span>
                    </div><!-- /.input-group -->
                </div>
            @endif

            <div class="form-group">
                <label>{{ trans('ecommerce.shipment') }} ({{ trans('geo.international') }})</label>
                <div class="input-group">
                    <input name="international_shipment" value="{{ $designer->international_shipment }}" type="number"
                        min="0.00" max="999.99" step="1" class="form-control">
                        <span class="input-group-addon" id="sizing-addon2">&euro; EUR</span>
                </div><!-- /.input-group -->
            </div>
        </fieldset>

        <fieldset class="scheduler-border">
            <legend class="scheduler-border">{{ trans('ecommerce.return_address') }}</legend>

            <p class="text-muted">{{ trans('ecommerce.return_address_tip') }}</p>

            <div class="form-group">
                <label>{{ trans('ecommerce.recipient') }}</label>
                <input name="address[name]" value="{{ $designer->address_id ? $designer->address->name : $designer->name }}" type="text" maxlength="255" class="form-control">
            </div>

            <div class="form-group">
                <label>{{ trans('geo.address') }}</label>
                <input name="address[street]" value="{{ $designer->address_id ? $designer->address->street : '' }}" type="text"
                    maxlength="255" class="form-control">
            </div>

            <div class="form-group">
                <label>{{ trans('geo.postcode') }}</label>
                <input name="address[postcode]" value="{{ $designer->address_id ? $designer->address->postcode : '' }}" type="text"
                    maxlength="255" class="form-control">
            </div>

            <div class="form-group">
                <label>{{ trans('geo.city') }}</label>
                @include('components.selects.city-select', [
                    'selected' => $designer->address_id ? $designer->address->city : $designer->city,
                    'id' => 'address-city-select',
                    'name' => 'address[city_id]',
                ])
            </div>

            <div class="form-group">
                <label>{{ trans('common.email') }}</label>
                <input name="address[email]" value="{{ $designer->address_id ? $designer->address->email : $designer->email }}" type="email" maxlength="255" class="form-control">
            </div>

            <div class="form-group">
                <label>{{ trans('common.phone') }}</label>
                <input name="address[phone]" value="{{ $designer->address_id ? $designer->address->phone : $designer->phone }}" type="tel" maxlength="255" class="form-control">
            </div>
        </fieldset>


        <button type="submit" class="btn btn-primary">{{ trans('common.save') }}</button>

        <a class="btn btn-link" href="{{ $designer->url }}">{{ trans('common.cancel') }}</a>

    </form>
</div><!-- /.container -->

@endsection

@push('templates')
    @include('templates.image-preview')
@endpush

@push('modals')
    @include('components.upload.image-manager')
@endpush
