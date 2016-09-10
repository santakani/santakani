<div id="transfer-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{ trans('common.transfer') }}</h4>
            </div>
            <div class="modal-body">
                <p class="text-center">
                    @if (count($user))
                        <a href="{{ $user->url }}" target="_blank">
                            <img class="img-circle" src="{{ $user->medium_avatar_url }}" width="50" height="50"/>
                            <br/>
                            {{ $user->name }}
                        </a>
                    @else
                        {{ trans('common.unknown') }}
                    @endif
                </p>
                <p class="text-center"><i class="fa fa-angle-double-down"></i></p>
                @include('components.select.user-select')
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('common.cancel') }}</button>
                <button type="button" class="confirm-button btn btn-primary">{{ trans('common.confirm') }}</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
