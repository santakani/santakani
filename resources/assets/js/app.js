/**
 * Load all JavaScript
 */

(function () {

    // Bootstrap needs 'jQuery' global variable. Other jQuery plugins may also
    // require '$' or 'jQuery'.
    window.$ = window.jQuery = require('jquery');
    require('bootstrap-sass');
    require('selectize');
    require('lightgallery');
    window._ = require('underscore');

    // Load jQuery plugins
    require('./jquery/go-to');

    // Layout
    require('./layout/footer');

    // Pages
    require('./page/home');

    require('./page/designer/index');
    require('./page/designer/create');
    require('./page/designer/show');
    require('./page/designer/edit');

    require('./page/place/index');
    require('./page/place/create');
    require('./page/place/show');
    require('./page/place/edit');

    require('./page/story/index');
    require('./page/story/edit');
    require('./page/story/show');

    require('./page/tag/edit');

    require('./page/setting/account');
})();
