@extends('layouts.app', [
    'title' => trans('common.help'),
    'body_id' => 'help-page',
    'body_classes' => ['help-page', 'site-page'],
])

@section('header')
    <div class="container">
        <h1 class="page-header">{{ trans('common.help') }}</h1>
    </div>
@endsection

@section('main')
    <section id="login-section">
        <div class="container">
            <h2>Register &amp; Login</h2>

            <h3 id="help-register">Register</h3>

            <p>If you do not have an account, it is time for registering! After that, you will get extra functions.</p>

            <div class="step">
                <div class="step-number">1</div>
                <div class="step-text">
                    <h4>Click <em>Register</em> button on navbar</h4>
                    <p>Then you will open the register form.</p>
                </div>
                <div class="step-image">
                    <img src="/img/help/screenshots/en/navbar-right-guest.png">
                </div>
            </div>

            <div class="step">
                <div class="step-number">2</div>
                <div class="step-text">
                    <h4>Click Facebook/Twitter/Google login, or fill email address and password</h4>
                    <p>If you use Facebook/Twitter/Google login, Santakani will bring you to their websites and you need confirm by click a button.</p>
                    <p>If you use the form, you need to type all necessary information: name, email address and password.</p>
                    <p>Use a valid email address. Email address will be used for login and reset password when you forget it.</p>
                    <p>Use a strong password to protect your account.</p>
                </div>
                <div class="step-image">
                    <img src="/img/help/screenshots/en/register-form.png">
                </div>
            </div>

            <div class="step">
                <div class="step-number">3</div>
                <div class="step-text">
                    <h4>Back to your last visited page</h4>
                    <p>If register succeeded, you will be redirected to the last page you visited. You are logged in now!</p>
                </div>
            </div>

            <h3 id="help-login">Login</h3>

            <p>You need login to create designer and place pages, post stories, comment and like.</p>

            <div class="step">
                <div class="step-number">1</div>
                <div class="step-text">
                    <h4>Click <em>Login</em> button on navbar</h4>
                    <p>Then you will open the login form.</p>
                </div>
                <div class="step-image">
                    <img src="/img/help/screenshots/en/navbar-right-guest.png">
                </div>
            </div>

            <div class="step">
                <div class="step-number">2</div>
                <div class="step-text">
                    <h4>Choose login methods</h4>
                    <p>If you use Facebook, just click the <strong>Facebook Login</strong> button. You will be automatically logged in. If you didn't login your Facebook account or authorize Santakani before, it will bring you to Facebook website. You need to login or authorize manually. The same with Google and Twitter.</p>
                    <p>If you use the form, you need to type all necessary information: name, email address and password.</p>
                    <p>Use a valid email address. Email address will be used for login and reset password when you forget it.</p>
                    <p>Use a strong password to protect your account.</p>
                </div>
                <div class="step-image">
                    <img src="/img/help/screenshots/en/login-form.png">
                </div>
            </div>

            <div class="step">
                <div class="step-number">3</div>
                <div class="step-text">
                    <h4>Back to your last visited page</h4>
                    <p>If login succeeded, you will be redirected to the last page you visited. You are logged in now!</p>
                </div>
            </div>
        </div>
    </section>

    <section id="login-section">
        <div class="container">
            <h2>Designer Page</h2>

            <h3 id="help-create-designer-page">Create a designer page</h3>

            <p>To create a designer page, you must <strong>login</strong>.</p>

            <p>Any user can create designer pages for free. Designer pages must be meaningful: they should have name, content and images. Empty or meaningless pages would be deleted.</p>

            <div class="step">
                <div class="step-number">1</div>
                <div class="step-text">
                    <h4>Click <em>Create</em> button on navbar and choose <em>Designer</em></h4>
                    <p>Then you will open a form page.</p>
                </div>
                <div class="step-image">
                    <img src="/img/help/screenshots/en/create-menu-designer.png">
                </div>
            </div>

            <div class="step">
                <div class="step-number">2</div>
                <div class="step-text">
                    <h4>Fill designer create form</h4>
                    <p>You need to input some basic information of the designer or brand. Note: email is optional and you can leave it empty if do not want to be borthered.</p>
                    <p>Type name of your city, the dropdown list will show possible cities in system.</p>
                    <p>After finished everything, click "Create" button at the bottom. You will open an edit form to input more information.</p>
                </div>
                <div class="step-image">
                    <img src="/img/help/screenshots/en/create-designer-form.png">
                </div>
            </div>

            <div class="step">
                <div class="step-number">3</div>
                <div class="step-text">
                    <h4>Click <em>Create</em> button, open edit form</h4>
                    <p>Now a new designer page has been created. You will open an edit form to input more information.</p>
                </div>
            </div>

            <div class="step">
                <div class="step-number">4</div>
                <div class="step-text">
                    <h4><em>Design philosophy</em> and <em>About</em></h4>
                    <p>Design philosophy is a short expression of ideas and values behind your design.</p>
                    <p>About is a longer description of your design stories, knowledge, works and dreams. You can also insert links, images, and YouTube/Vimeo videos.</p>
                    <p>You can translate your designer page to different languages by clicking language tabs in edit form. Our editor team will also help to translate.</p>
                </div>
                <div class="step-image">
                    <img src="/img/help/screenshots/en/designer-edit-form-translation.png">
                </div>
            </div>

            <div class="step">
                <div class="step-number">5</div>
                <div class="step-text">
                    <h4>Go to <em>Cover image</em> section, click <em>Choose image</em></h4>
                    <p>You will open a image manager.</p>
                </div>
                <div class="step-image">
                    <img src="/img/help/screenshots/en/designer-edit-form-cover-image.png">
                </div>
            </div>

            <div class="step">
                <div class="step-number">6</div>
                <div class="step-text">
                    <h4>Click <em>Upload</em> and select image files in your computer</h4>
                </div>
                <div class="step-image">
                    <img src="/img/help/screenshots/en/designer-edit-form-image-manager-empty.png">
                </div>
            </div>

            <div class="step">
                <div class="step-number">7</div>
                <div class="step-text">
                    <h4>Click images to choose and click <em>OK</em> to insert as cover</h4>
                </div>
                <div class="step-image">
                    <img src="/img/help/screenshots/en/designer-edit-form-image-manager-new.png">
                </div>
            </div>

            <div class="step">
                <div class="step-number">8</div>
                <div class="step-text">
                    <h4>View new cover image. Follow the same steps to choose logo image.</h4>
                </div>
                <div class="step-image">
                    <img src="/img/help/screenshots/en/designer-edit-form-cover-image-new.png">
                </div>
            </div>

            <div class="step">
                <div class="step-number">9</div>
                <div class="step-text">
                    <h4>Go to "Gallery" section and click "Choose image" button</h4>
                </div>
                <div class="step-image">
                    <img src="/img/help/screenshots/en/designer-edit-form-gallery.png">
                </div>
            </div>

            <div class="step">
                <div class="step-number">10</div>
                <div class="step-text">
                    <h4>Upload and choose images, then click "OK"</h4>
                </div>
                <div class="step-image">
                    <img src="/img/help/screenshots/en/designer-edit-form-image-manager-multiple.png">
                </div>
            </div>

            <div class="step">
                <div class="step-number">11</div>
                <div class="step-text">
                    <h4>Drag images to change their order</h4>
                </div>
                <div class="step-image">
                    <img src="/img/help/screenshots/en/designer-edit-form-gallery-sort.png">
                </div>
            </div>

            <div class="step">
                <div class="step-number">12</div>
                <div class="step-text">
                    <h4>Go to "Tags" section. Search or select tags.</h4>
                </div>
                <div class="step-image">
                    <img src="/img/help/screenshots/en/designer-edit-form-tag-select.png">
                </div>
            </div>

            <div class="step">
                <div class="step-number">13</div>
                <div class="step-text">
                    <h4>Fill links</h4>
                </div>
                <div class="step-image">
                    <img src="/img/help/screenshots/en/designer-edit-form-links.png">
                </div>
            </div>

            <div class="step">
                <div class="step-number">14</div>
                <div class="step-text">
                    <h4>Click "Save" button</h4>
                </div>
                <div class="step-image">
                    <img src="/img/help/screenshots/en/designer-edit-form-save.png">
                </div>
            </div>

            <div class="step">
                <div class="step-number">15</div>
                <div class="step-text">
                    <h4>View result</h4>

                    <p>You can edit your designer page at anytime. Simply click the "Edit" button on top right corner.</p>
                </div>
                <div class="step-image">
                    <p><img src="/img/help/screenshots/en/designer-page-1.png"></p>
                    <p><img src="/img/help/screenshots/en/designer-page-2.png"></p>
                    <p><img src="/img/help/screenshots/en/designer-page-3.png"></p>
                </div>
            </div>
        </div>
    </section>
@endsection
