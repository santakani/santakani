/**
 * Control designer edit form.
 *
 * View - views/designer/edit.blade.php
 * Style - assets/sass/_edit-layout.scss
 * Script - assets/js/edit/ajax/designer-edit.js
 */

// TinyMCE is loaded by HTML <script> tag. Browserify support is not finished.

var ImagePreview = require('../../views/image-preview');
var Image = require('../../models/image');
var ImageManager = require('../../views/image-manager');
var ContentEditor = require('../../views/content-editor');
var GalleryEditor = require('../../views/gallery-editor');
var CitySelect = require('../../views/city-select');
var TagSelect = require('../../views/tag-select');

require('../../components/forms/edit-form');

$(function () {

    // Page check
    if ($('#designer-edit-page').length === 0) {
        return;
    }

    // Image manager
    var manager = new ImageManager({
        parentType: 'designer',
        parentId: parseInt($('form').data('id'))
    });

    // Cover
    var coverPreview = new ImagePreview({
        el: '#image-form-group .image-preview',
        width: 600,
        height: 200,
        size: 'medium',
        inputName: 'image_id',
    });

    $('#image-form-group button').click(function () {
        manager.call({
            multiple: false,
            done: function (image) {
                coverPreview.model.set(image);
            }
        });
    });

    $('.content-editor').each(function () {
        var contentEditor = new ContentEditor({el: this, imageManager: manager});
    });

    var galleryEditor = new GalleryEditor({el: '#gallery-editor', imageManager: manager});

    var citySelect = new CitySelect({el: '.city-select'});
    var tagSelect = new TagSelect({el: '.tag-select'});

});
