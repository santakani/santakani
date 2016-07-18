// Main JavaScript file. Load all JavaScripts.


//==============================
// Libraries
//==============================

// Bootstrap needs 'jQuery' global variable.
window.$ = window.jQuery = require('jquery');

// Underscore is often used.
window._ = require('underscore');

// Bootstrap, not packaged as Common.js or AMD module.
require('bootstrap-sass');

// jQuery plugins
require('selectize');
require('lightgallery');
require('jquery.scrollto');


//==============================
// Services
//==============================


//==============================
// Components
//==============================

require('./components/auth-modal');

require('./components/tabs/auto-collapse');



//==============================
// Layouts
//==============================

// App layout
require('./layouts/app/footer');



//==============================
// Pages
//==============================

// Home page
if (document.getElementById('home-page')) {
    require('./pages/home');
}

// Designer
if (document.getElementById('designer-index-page')) {
    require('./pages/designer/index');
}
if (document.getElementById('designer-create-page')) {
    require('./pages/designer/create');
}
if (document.getElementById('designer-show-page')) {
    require('./pages/designer/show');
}
if (document.getElementById('designer-edit-page')) {
    require('./pages/designer/edit');
}

// Place
if (document.getElementById('place-index-page')) {
    require('./pages/place/index');
}
if (document.getElementById('place-create-page')) {
    require('./pages/place/create');
}
if (document.getElementById('place-show-page')) {
    require('./pages/place/show');
}
if (document.getElementById('place-edit-page')) {
    require('./pages/place/edit');
}

// Story
if (document.getElementById('story-index-page')) {
    require('./pages/story/index');
}
if (document.getElementById('story-show-page')) {
    require('./pages/story/show');
}
if (document.getElementById('story-edit-page')) {
    require('./pages/story/edit');
}

// Tag
if (document.getElementById('tag-show-page')) {
    require('./pages/tag/show');
}
if (document.getElementById('tag-edit-page')) {
    require('./pages/tag/edit');
}

// User settings
if (document.getElementById('profile-setting-page')) {
    require('./pages/setting/profile');
}
if (document.getElementById('account-setting-page')) {
    require('./pages/setting/account');
}

// Admin panel
if (document.getElementById('user-admin-page')) {
    require('./pages/admin/user');
}
if (document.getElementById('deleted-user-admin-page')) {
    require('./pages/admin/deleted-user');
}
