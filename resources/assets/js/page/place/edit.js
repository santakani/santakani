/**
 * Control designer edit form.
 *
 * View - views/designer/edit.blade.php
 * Style - assets/sass/_edit-layout.scss
 * Script - assets/js/edit/ajax/designer-edit.js
 */

var ImagePreview = require('../../view/image-preview');
var Image = require('../../model/image');
var ImageManager = require('../../view/image-manager');
var ContentEditor = require('../../view/content-editor');
var GalleryEditor = require('../../view/gallery-editor');
var CountrySelect = require('../../view/country-select');
var CitySelect = require('../../view/city-select');
var TagSelect = require('../../view/tag-select');

$(function () {

    // Page check
    if ($('#place-edit-page').length === 0) {
        return;
    }

    // Image manager
    var manager = new ImageManager({
        parentType: 'place',
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

    var contentEditor = new ContentEditor({el: '#input-content', imageManager: manager});

    var galleryEditor = new GalleryEditor({el: '#gallery-editor', imageManager: manager});

    var countrySelect = new CountrySelect({el: '.country-select'});
    var citySelect = new CitySelect({el: '.city-select'});
    var tagSelect = new TagSelect({el: '.tag-select'});

    // Submit form
    $('button[type="submit"]').click(function (e) {
        e.preventDefault();

        $.ajax({
            method: 'PUT',
            url: $('#place-edit-form').attr('action'),
            data: $('#place-edit-form').serializeArray()
        }).done(function () {
            window.location.href = $('#place-edit-form').attr('action');
        }).fail(function (error) {
            var response = error.responseJSON;
            var $alert = $('#place-edit-form .alert');
            var message = '';

            for (var id in response) {
                message += '<p>' + response[id] + '</p>';
            }

            $alert.html(message).show().goTo();
        });
    });

});
