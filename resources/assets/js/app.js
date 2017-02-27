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
require('lightslider');
require('jquery.scrollto');

require('./jquery/remove-attributes');


//==============================
// Services
//==============================


//==============================
// Components
//==============================

require('./components/auth-modal');

require('./components/buttons/editor-rating-button');

require('./components/page-cover');

require('./components/tabs/auto-collapse');

require('./components/qrcode');



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
} else if (document.getElementById('about-page')) {
    require('./pages/about');
}

// Design
else if (document.getElementById('design-index-page')) {
    require('./pages/design/index');
}
else if (document.getElementById('design-edit-page')) {
    require('./pages/design/edit');
}
else if (document.getElementById('design-show-page')) {
    require('./pages/design/show');
}

// Designer
else if (document.getElementById('designer-index-page')) {
    require('./pages/designer/index');
}
else if (document.getElementById('designer-create-page')) {
    require('./pages/designer/create');
}
else if (document.getElementById('designer-show-page')) {
    require('./pages/designer/show');
}
else if (document.getElementById('designer-edit-page')) {
    require('./pages/designer/edit');
}

// Place
else if (document.getElementById('place-index-page')) {
    require('./pages/place/index');
}
else if (document.getElementById('place-create-page')) {
    require('./pages/place/create');
}
else if (document.getElementById('place-show-page')) {
    require('./pages/place/show');
}
else if (document.getElementById('place-edit-page')) {
    require('./pages/place/edit');
}

// Story
else if (document.getElementById('story-index-page')) {
    require('./pages/story/index');
}
else if (document.getElementById('story-show-page')) {
    require('./pages/story/show');
}
else if (document.getElementById('story-edit-page')) {
    require('./pages/story/edit');
}

// Tag
else if (document.getElementById('tag-show-page')) {
    require('./pages/tag/show');
}
else if (document.getElementById('tag-edit-page')) {
    require('./pages/tag/edit');
}

// User settings
else if (document.getElementById('profile-setting-page')) {
    require('./pages/setting/profile');
}
else if (document.getElementById('account-setting-page')) {
    require('./pages/setting/account');
}

// Admin panel
else if (document.getElementById('user-admin-page')) {
    require('./pages/admin/user');
}
else if (document.getElementById('deleted-user-admin-page')) {
    require('./pages/admin/deleted-user');
}

else if (document.getElementById('trash-page')) {
    require('./pages/trash');
}

$('.logout-action').click(function (e) {
    e.preventDefault();

    $.ajax({
        url: '/logout',
        method: 'post',
        data: {
            _token: app.token
        }
    }).done(function () {
        window.location = '/';
    });
});
