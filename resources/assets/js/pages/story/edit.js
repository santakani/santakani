/**
 * Story edit form.
 */

var Image = require('../../models/image');

var ImageChooser = require('../../views/upload/image-chooser');
var ImagePreview = require('../../views/upload/image-preview');
var ImageManager = require('../../views/upload/image-manager');
var ContentEditor = require('../../views/content-editor');
var TagSelect = require('../../views/tag-select');
var EditForm = require('../../views/forms/edit-form');

// Image manager
var manager = new ImageManager({
    parentType: 'story',
    parentId: $('#story-edit-form').data('id')
});

// Translation Tabs
$('#translation-tabs > li:not(.dropdown) > a, #translation-tabs ul a').click(function (e) {
    e.preventDefault();
    if (!$(this).hasClass('more')) {
        $(this).tab('show');
    }
});

$('.content-editor').each(function () {
    new ContentEditor({el: this, imageManager: manager});
});

// Cover chooser
var coverChooser = new ImageChooser({
    el: '#cover-chooser',
    width: 600,
    height: 200,
    manager: manager,
    inputName: 'image_id',
});

var tagSelect = new TagSelect({el: '.tag-select'});

var editForm = new EditForm({el: '#story-edit-form'});
