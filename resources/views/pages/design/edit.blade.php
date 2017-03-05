@extends('layouts.app', [
    'title' => trans('common.edit') . ' ' . $design->text('name'),
    'body_id' => 'design-edit-page',
    'body_classes' => ['design-edit-page', 'edit-page', 'design-page'],
    'active_nav' => 'design',
])

@section('main')
<div class="container">

    <h1 class="page-header">{{ trans('common.edit') }} <a href="{{ $design->url }}">{{ $design->text('name') }}</a></h1>

    <form id="design-edit-form" class="edit-form" action="{{ $design->url }}" data-id="{{ $design->id }}" data-type="design">

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
                'width' => 300,
                'height' => 300,
                'size' => 'thumb',
            ])
            <p class="text-muted">{{ trans('image.recommended_size', ['width' => 600, 'height' => 600]) }}
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

        <fieldset class="scheduler-border">
            <legend class="scheduler-border">Purchase</legend>

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

            <div class="form-group">
                <label>Shipped from</label>
                @include('components.selects.country-select', ['selected' => $design->country_id])
            </div>

            <div class="form-group">
                <label>National shipment price</label>
                <input name="national_shipment_price" value="{{ $design->national_shipment_price }}" type="number" class="form-control">
            </div>

            <div class="form-group">
                <label>International shipment price</label>
                <input name="international_shipment_price" value="{{ $design->international_shipment_price }}" type="number" class="form-control">
            </div>

        </fieldset>

        <fieldset class="scheduler-border">
            <legend class="scheduler-border">Options</legend>
            <input name="options" value="{{ $design->options }}" type="hidden">

            <template id="option-editor-template">
                <td>
                    <span class="drag-handle btn-icon btn-icon-sm"><span class="icon ion-arrow-move"></span></span>
                </td>
                <td><input type="text" value="" class="name-input form-control input-sm"></td>
                <td><input type="number" value="" class="price-add-input form-control input-sm" max="999999" min="-999999"></td>
                <td>
                    <input type="color" value="" class="color-input form-control input-sm">
                </td>
                <td>
                    <button class="image-button btn btn-default btn-sm" type="button">Choose image</button>
                </td>
                <td>
                    <button class="delete-button btn-icon btn-icon-danger btn-icon-sm" type="button" href="#"><span class="icon ion-close"></span></button>
                </td>
            </template>

            <div class="form-group">
                <label>Color options</label>
                <table id="color-options" class="table table-hover" data-collection="{{ $colors }}">
                    <thead>
                        <tr class="option">
                            <th></th>
                            <th class="name">Color name</th>
                            <th class="price_add">Price add</th>
                            <th class="color">Color</th>
                            <th class="image">Image</th>
                            <th></th>
                        </tr>
                    <thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td colspan="4"><button class="add-button btn btn-default btn-sm" type="button">Create new option</button></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="form-group">
                <label>Size options</label>
                <div id="size-options" data-collection="{{ $sizes }}">

                </div>
            </div>

            <div class="form-group">
                <label>Material options</label>
                <div id="material-options" data-collection="{{ $materials }}">

                </div>
            </div>

        </fieldset>

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
