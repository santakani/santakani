/**
 * Load all JavaScript
 */

(function () {

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
