@extends('layouts.settings', [
    'title' => trans('geo.address'),
    'body_id' => 'address-setting-page',
    'body_classes' => ['address-setting-page'],
    'active_section' => 'address',
])

@section('setting_body')

<h1 class="page-header">
    {{ trans('geo.address') }}
</h1>





<div id="address-manager" data-collection="{{ $addresses }}">
    <p class="text-right">
        <button type="button" class="create-button btn btn-success">
            <span class="ion-plus"></span> {{ trans('common.create') }}
        </button>
    </p>
    <div class="address-list"></div>
</div>

@endsection

@push('templates')

    <template id="address-card-template">
        <div class="panel-heading name"></div>
        <div class="panel-body">
            <p class="street"></p>
            <p>
                <span class="city"></span>
                <span class="postcode"></span>
            </p>
            <p class="country"></p>
            <p class="phone"></p>
            <p class="email"></p>
        </div>
        <div class="panel-footer text-right">
                <button type="button" class="edit-button btn btn-default">{{ trans('common.edit') }}</button>
                <button type="button" class="delete-button btn btn-danger">{{ trans('common.delete') }}</button>
            </div>
    </template>

@endpush

@push('modals')

    <div id="address-modal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{ trans('geo.address') }}</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">{{ trans('common.name') }}</label>
                            <div class="col-sm-9">
                                <input name="name" type="text" class="form-control">
                                <span class="help-block">
                                    <strong></strong>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">{{ trans('geo.address') }}</label>
                            <div class="col-sm-9">
                                <input name="street" type="text" class="form-control">
                                <span class="help-block">
                                    <strong></strong>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">{{ trans('geo.postcode') }}</label>
                            <div class="col-sm-9">
                                <input name="postcode" type="text" class="form-control">
                                <span class="help-block">
                                    <strong></strong>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">{{ trans('geo.city') }}</label>
                            <div class="col-sm-9">
                                @include('components.selects.city-select')
                                <span class="help-block">
                                    <strong></strong>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">{{ trans('common.email') }}</label>
                            <div class="col-sm-9">
                                <input name="email" type="email" class="form-control">
                                <span class="help-block">
                                    <strong></strong>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">{{ trans('common.phone') }}</label>
                            <div class="col-sm-9">
                                <input name="phone" type="tel" class="form-control">
                                <span class="help-block">
                                    <strong></strong>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="cancel-button btn btn-default" data-dismiss="modal">{{ trans('common.cancel') }}</button>
                    <button type="button" class="save-button btn btn-primary">{{ trans('common.save') }}</button>
                </div>
            </div>
        </div>
    </div>

@endpush
