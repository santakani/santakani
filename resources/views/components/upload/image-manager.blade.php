<div id="image-manager" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>

                <h4 class="modal-title">
                    {{ trans('common.images') }}

                    <button type="button" class="upload-button btn btn-success">
                        <i class="fa fa-cloud-upload"></i> {{ trans('common.upload') }}
                    </button>
                    <input type="file" class="file-input hidden" accept="image/jpeg,image/png,image/gif">
                </h4>
            </div>
            <div class="modal-body">
                <div class="gallery clearfix"></div>
                <div class="alert alert-info"> {{ trans('image.no_image_please_upload') }}</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="cancel-button btn btn-default" data-dismiss="modal">{{ trans('common.cancel') }}</button>
                <button type="button" class="ok-button btn btn-primary">{{ trans('common.ok') }}</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
