/**
 * Load all JavaScript
 */

(function () {

    var npmPath = '../../../node_modules';

    // Libraries
    require('openlayers');

    // jQuery plugins
    require('./jquery/go-to');

    // Utilities
    require('./utility/template');

    // Pages
    require('./page/designer/show');
    require('./page/designer/edit');

    require('./page/place/index');
})();
