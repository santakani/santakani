/**
 * Load all JavaScript
 */

(function () {

    // Bootstrap needs 'jQuery' global variable. Other jQuery plugins may also
    // require '$' or 'jQuery'.
    window.$ = window.jQuery = require('jquery');
    require('bootstrap-sass');
    window._ = require('underscore');

    // Load jQuery plugins
    require('./jquery/go-to');

    // Pages
    require('./page/designer/create');
    require('./page/designer/show');
    require('./page/designer/edit');

    require('./page/place/index');
    require('./page/place/create');
    require('./page/place/show');
    require('./page/place/edit');
})();
