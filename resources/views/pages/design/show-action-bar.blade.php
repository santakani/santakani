<div class="action-bar">

    @if ($design->webshop)
        <div class="action">
            <a class="btn-icon" href="{{ $design->webshop }}" target="_blank" title="{{ trans('common.buy') }}">
                <span class="icon ion-ios-cart-outline"></span>
                <span class="text">{{ trans('common.buy') }}</span>
            </a>
        </div>
    @endif

    <div class="action">
        @include('components.buttons.like', ['likeable' => $design, 'has_text' => true])
    </div>

    <div class="action">
        <div class="dropdown">
            <button type="button" class="btn-icon dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="{{ trans('common.share') }}">
                <span class="icon ion-ios-upload-outline"></span>
                <span class="text">{{ trans('common.share') }}</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-right">
                <li><a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($design->url) }}" target="_blank">Facebook</a></li>
                <li><a href="https://plus.google.com/share?url={{ urlencode($design->url) }}" target="_blank">Google+</a></li>
                <li><a href="https://twitter.com/intent/tweet?hashtags=santakanidesign&amp;url={{ urlencode($design->url) }}" target="_blank">Twitter</a></li>
                <li><a href="http://www.tumblr.com/share/link?url={{ urlencode($design->url) }}" target="_blank">Tumblr</a></li>

                <li><a href="#">
                    微信
                    <img class="qrcode" src="" data-url="{{ $design->url }}" width="300" height="300">
                </a></li>

            </ul>
        </div>
    </div>

    @if (Auth::check() && Auth::user()->can('edit-design', $design))
        <div class="action">
            <a id="edit-button" class="btn-icon" href="{{ url()->current() . '/edit' }}" title=" {{ trans('common.edit') }}">
                <span class="icon ion-ios-compose-outline"></span>
                <span class="text">{{ trans('common.edit') }}</span>
            </a>
        </div>
    @endif

    <div class="action">
        <div class="dropdown">
            <button type="button" class="btn-icon dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="{{ trans('common.more') }}">
                <span class="icon ion-ios-more-outline"></span>
                <span class="text">{{ trans('common.more') }}</span>
            </button>

            <ul class="dropdown-menu dropdown-menu-right">
                @if (Auth::check() && Auth::user()->can('editor-rating'))
                    <li>
                        <a id="editor-rating-button" class="editor-rating-button" href="{{ $design->url }}" data-rating="{{ $design->editor_rating }}">
                            {{ trans('common.editor_rating') }}
                        </a>
                    </li>
                @endif

                @if (Auth::check() && Auth::user()->can('transfer-design', $design))
                    <li>
                        <a id="transfer-button" href="#" data-toggle="modal" data-target="#transfer-modal">
                            {{ trans('common.transfer') }}
                        </a>
                    </li>
                @endif

                @if (Auth::check() && Auth::user()->can('delete-design', $design))
                    <li>
                        <a id="delete-button" href="#">
                            {{ trans('common.delete') }}
                        </a>
                    </li>
                    @if (Auth::user()->role === 'admin' || Auth::user()->role === 'editor')
                        <li>
                            <a id="force-delete-button" href="#">
                                {{ trans('common.delete_permanently') }}
                            </a>
                        </li>
                    @endif
                @endif
                <li>
                    <a href="mailto:contact@santakani.com?subject=[Santakani] Report Problems&amp;body=Please describe problems on page {{ $design->url }}">
                        {{ trans('common.report') }}
                    </a>
                </li>
            </ul>
        </div><!-- /.dropdown -->
    </div>
</div><!-- /.action-bar -->
