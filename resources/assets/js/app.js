/*
 * Main JavaScript file. Load all JavaScripts.
 */


//==============================================================================
// Libraries
//==============================================================================

// Bootstrap needs 'jQuery' global variable.
window.$ = window.jQuery = require('jquery');

// Underscore is often used.
window._ = require('underscore');

// Bootstrap is not packaged.
require('bootstrap-sass');

// jQuery plugins
require('selectize');
require('lightgallery');
require('./jquery/go-to');



//==============================================================================
// Components
//==============================================================================

require('./components/auth-modal');



//==============================================================================
// Layouts
//==============================================================================

// App layout
require('./layout/footer');



//==============================================================================
// Pages
//==============================================================================

// Home page
require('./page/home');

// Designer
require('./page/designer/index');
require('./page/designer/create');

if($('#designer-show-page').length) {
    require('./page/designer/show');
}

require('./page/designer/edit');

// Place
require('./page/place/index');
require('./page/place/create');
require('./page/place/show');
require('./page/place/edit');

// Story
require('./page/story/index');
require('./page/story/edit');
require('./page/story/show');

// Tag
require('./page/tag/edit');
require('./page/tag/show');

// User settings
require('./page/setting/profile');
require('./page/setting/account');
