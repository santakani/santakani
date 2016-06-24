<div id="auth-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Login to continue...</h4>
            </div>
            <div class="modal-body">
                <from class="form-horizontal">
                    <div class="form-group">
                        <div class="col-sm-6 col-sm-offset-3">
                            <a class="btn btn-primary btn-lg btn-block" href="/auth/facebook">
                                <i class="fa fa-facebook-official fa-lg"></i>
                                Facebook {{ trans('common.login') }}
                            </a>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-6 col-sm-offset-3">
                            <a class="btn btn-danger btn-lg btn-block" href="/auth/google">
                                <i class="fa fa-google fa-lg"></i>
                                Google {{ trans('common.login') }}
                            </a>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-6 col-sm-offset-3">
                            <a class="btn btn-info btn-lg btn-block" href="/auth/twitter">
                                <i class="fa fa-twitter fa-lg"></i>
                                Twitter {{ trans('common.login') }}
                            </a>
                        </div>
                    </div>
                </form>

                <p class="text-center text-muted">{{ strtolower(trans('common.or')) }}</p>

                <ul class="nav nav-tabs nav-justified" role="tablist">
                    <li role="presentation" class="active"><a href="#login-pane" aria-controls="home" role="tab" data-toggle="tab">Login</a></li>
                    <li role="presentation"><a href="#register-pane" aria-controls="profile" role="tab" data-toggle="tab">Register</a></li>
                </ul>

                <br>

                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active" id="login-pane">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">

                            {!! csrf_field() !!}

                            <div class="form-group">
                                <label class="col-sm-3 control-label">{{ trans('common.email') }}</label>

                                <div class="col-sm-8 col-lg-6">
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">{{ trans('common.password') }}</label>

                                <div class="col-sm-8 col-lg-6">
                                    <input type="password" class="form-control" name="password">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-9 col-sm-offset-3">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember"> Remember me
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-9 col-sm-offset-3">
                                    <button type="submit" class="btn btn-info">
                                        {{ trans('common.login') }}
                                    </button>

                                    <a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot your password?</a>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="register-pane">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">

                            {!! csrf_field() !!}

                            <div class="form-group">
                                <label class="col-sm-3 control-label">{{ trans('common.name') }}</label>

                                <div class="col-sm-8 col-lg-6">
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">{{ trans('common.email') }}</label>

                                <div class="col-sm-8 col-lg-6">
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">{{ trans('common.password') }}</label>

                                <div class="col-sm-8 col-lg-6">
                                    <input type="password" class="form-control" name="password">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">{{ trans('common.confirm') }}</label>

                                <div class="col-sm-8 col-lg-6">
                                    <input type="password" class="form-control" name="password_confirmation">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-9 col-sm-offset-3">
                                    <button type="submit" class="btn btn-info">
                                        {{ trans('common.register') }}
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div><!-- .tab-content -->
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
