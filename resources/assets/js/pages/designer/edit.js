/**
 * Control designer edit form.
 *
 * View - views/designer/edit.blade.php
 * Style - assets/sass/_edit-layout.scss
 * Script - assets/js/edit/ajax/designer-edit.js
 */

// TinyMCE is loaded by HTML <script> tag. Browserify support is not finished.

var Image = require('../../models/image');

var ImageChooser = require('../../views/upload/image-chooser');
var ImagePreview = require('../../views/upload/image-preview');
var ImageManager = require('../../views/upload/image-manager');
var ContentEditor = require('../../views/content-editor');
var GalleryEditor = require('../../views/upload/gallery-editor');
var CitySelect = require('../../views/city-select');
var TagSelect = require('../../views/tag-select');
var EditForm = require('../../views/forms/edit-form');

// Image manager
var manager = new ImageManager({
    parentType: 'designer',
    parentId: $('#designer-edit-form').data('id')
});

// Cover chooser
var coverChooser = new ImageChooser({
    el: '#cover-chooser',
    manager: manager,
});

// Logo chooser
var logoChooser = new ImageChooser({
    el: '#logo-chooser',
    manager: manager,
});

$('.content-editor').each(function () {
    var contentEditor = new ContentEditor({el: this, imageManager: manager});
});

var galleryEditor = new GalleryEditor({el: '#gallery-editor', imageManager: manager});

var citySelect = new CitySelect({el: '.city-select'});
var tagSelect = new TagSelect({el: '.tag-select'});

var editForm = new EditForm({el: '#designer-edit-form'});
