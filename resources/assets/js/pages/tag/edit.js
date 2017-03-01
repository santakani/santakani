var ImageChooser = require('../../views/upload/image-chooser');
var ImageManager = require('../../views/upload/image-manager');
var EditForm = require('../../views/forms/edit-form');

// Image manager
var manager = new ImageManager({
    parentType: 'tag',
    parentId: $('#tag-edit-form').data('id')
});

// Translation Tabs
$('#translation-tabs a').click(function (e) {
    e.preventDefault();
    $(this).tab('show');
});

// Cover chooser
var coverChooser = new ImageChooser({
    el: '#cover-chooser',
    manager: manager,
});

var editForm = new EditForm({el: '#tag-edit-form'});
