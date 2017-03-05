var Image = require('../../models/image');

var ImageChooser = require('../../views/upload/image-chooser');
var ImagePreview = require('../../views/upload/image-preview');
var ImageManager = require('../../views/upload/image-manager');
var ContentEditor = require('../../views/content-editor');
var GalleryEditor = require('../../views/upload/gallery-editor');
var CitySelect = require('../../views/city-select');
var TagSelect = require('../../views/tag-select');
var EditForm = require('../../views/forms/edit-form');

var OptsetEditor = require('../../views/optset-editor');

// Image manager
var manager = new ImageManager({
    parentType: 'design',
    parentId: $('#design-edit-form').data('id')
});

// Cover chooser
var coverChooser = new ImageChooser({
    el: '#cover-chooser',
    manager: manager,
});

$('.content-editor').each(function () {
    var contentEditor = new ContentEditor({el: this, imageManager: manager});
});

var galleryEditor = new GalleryEditor({el: '#gallery-editor', imageManager: manager});

var tagSelect = new TagSelect({el: '.tag-select'});

var editForm = new EditForm({el: '#design-edit-form'});

new OptsetEditor({
    el: '#color-options',
    designId: $('#design-edit-form').data('id'),
    type: 'color',
    imageManager: manager,
    hasColor: true,
    hasImage: true,
});

new OptsetEditor({
    el: '#size-options',
    designId: $('#design-edit-form').data('id'),
    type: 'size',
    imageManager: manager,
    hasColor: false,
    hasImage: true,
});

new OptsetEditor({
    el: '#material-options',
    designId: $('#design-edit-form').data('id'),
    type: 'material',
    imageManager: manager,
    hasColor: false,
    hasImage: true,
});
