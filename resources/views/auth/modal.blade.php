<div id="auth-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <from class="form">
                    <div class="form-group">
                        <a class="btn btn-primary btn-lg btn-block"
                            href="{{ app_redirect_url('auth/facebook') }}">
                            <i class="fa fa-facebook-official fa-lg"></i>
                            Facebook {{ trans('common.login') }}
                        </a>
                    </div>

                    <div class="form-group">
                        <a class="btn btn-danger btn-lg btn-block"
                            href="{{ app_redirect_url('auth/google') }}">
                            <i class="fa fa-google fa-lg"></i>
                            Google {{ trans('common.login') }}
                        </a>
                    </div>

                    <div class="form-group">
                        <a class="btn btn-info btn-lg btn-block"
                            href="{{ app_redirect_url('auth/twitter') }}">
                            <i class="fa fa-twitter fa-lg"></i>
                            Twitter {{ trans('common.login') }}
                        </a>
                    </div>
                </form>

                <p class="text-center text-muted">{{ strtolower(trans('common.or')) }}</p>

                <ul class="nav nav-tabs nav-justified" role="tablist">
                    <li role="presentation" class="active"><a href="#login-pane" aria-controls="home" role="tab" data-toggle="tab">{{ trans('common.login') }}</a></li>
                    <li role="presentation"><a href="#register-pane" aria-controls="profile" role="tab" data-toggle="tab">{{ trans('common.register') }}</a></li>
                </ul>

                <br>

                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active" id="login-pane">
                        <form class="form" role="form" method="POST" action="{{ url('/login') }}">

                            {!! csrf_field() !!}

                            <div class="form-group email-form-group">
                                <label class="control-label">{{ trans('common.email_address') }}</label>
                                <input type="email" class="form-control" name="email">
                            </div>

                            <div class="form-group password-form-group">
                                <label class="control-label">{{ trans('common.password') }}</label>
                                <input type="password" class="form-control" name="password">
                            </div>

                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> {{ trans('auth.remember_me') }}
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-info">
                                    {{ trans('common.login') }}
                                </button>

                                <a class="btn btn-link" href="{{ url('/password/reset') }}">{{ trans('auth.forgot_your_password') }}</a>
                            </div>

                        </form>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="register-pane">
                        <form class="form" role="form" method="POST" action="{{ url('/register') }}">

                            {!! csrf_field() !!}

                            <div class="form-group name-form-group">
                                <label class="control-label">{{ trans('common.name') }}</label>
                                <input type="text" class="form-control" name="name">
                            </div>

                            <div class="form-group email-form-group">
                                <label class="control-label">{{ trans('common.email_address') }}</label>
                                <input type="email" class="form-control" name="email">
                            </div>

                            <div class="form-group password-form-group">
                                <label class="control-label">{{ trans('common.password') }}</label>
                                <input type="password" class="form-control" name="password">
                            </div>

                            <div class="form-group password_confirmation-form-group">
                                <label class="control-label">{{ trans('auth.confirm_password') }}</label>
                                <input type="password" class="form-control" name="password_confirmation">
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-info">
                                    {{ trans('common.register') }}
                                </button>
                            </div>

                        </form>
                    </div>
                </div><!-- .tab-content -->
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
