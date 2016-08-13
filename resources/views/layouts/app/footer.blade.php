<footer id="app-footer" class="app-footer">
    <div class="container-fluid">
        <ul class="list-inline">
            <li><a href="{{ url('privacy') }}">{{ trans('common.privacy') }}</a></li>
            <li><a href="{{ url('terms') }}">{{ trans('common.terms_of_service') }}</a></li>
            <li><a href="https://github.com/santakani/santakani.com" target="_blank">{{ trans('common.source_code') }}</a></li>
            <li><a href="{{ url('help') }}">{{ trans('common.help') }}</a></li>
            <li><a href="mailto:contact@santakani.com">{{ trans('common.contact') }}</a></li>
            <li><a href="{{ url('about') }}">{{ trans('common.about_us') }}</a></li>
            <li><a href="https://www.facebook.com/santakanidesign" target="_blank">Facebook</a></li>
            @if (App::getLocale() === 'zh')
                <li><a href="#" data-toggle="modal" data-target="#wechat-modal">微信</a></li>
            @endif
        </ul>
        <p>2016{{ date("Y") > 2016?'-'.date("Y"):'' }} {{ trans('brand.app_name') }}</p>
    </div>
</footer>
@if (App::getLocale() === 'zh')
    @push('modals')
        <div class="modal fade" id="wechat-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">微信公众号</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <img src="{{ url('img/qrcode/wechat-tiny-finland.jpg') }}">
                            </div>
                            <div class="col-sm-6">
                                <p>使用微信扫描二维码，关注我们的微信公众号“小芬兰”。</p>
                                <p>微信号: tiny_finland</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    </div>
                </div>
            </div><!--.modal-dialog-->
        </div><!--.modal-->
    @endpush
@endif
