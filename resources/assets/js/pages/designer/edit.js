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

require('../../components/forms/edit-form');

// Image manager
var manager = new ImageManager({
    parentType: 'designer',
    parentId: parseInt($('form').data('id'))
});

// Cover chooser
var coverChooser = new ImageChooser({
    el: '#cover-chooser',
    width: 600,
    height: 200,
    manager: manager,
    inputName: 'image_id',
});

// Logo chooser
var logoChooser = new ImageChooser({
    el: '#logo-chooser',
    manager: manager,
    inputName: 'logo_id',
});

$('.content-editor').each(function () {
    var contentEditor = new ContentEditor({el: this, imageManager: manager});
});

var galleryEditor = new GalleryEditor({el: '#gallery-editor', imageManager: manager});

var citySelect = new CitySelect({el: '.city-select'});
var tagSelect = new TagSelect({el: '.tag-select'});
