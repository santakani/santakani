/**
 * Control designer edit form.
 *
 * View - views/designer/edit.blade.php
 * Style - assets/sass/_edit-layout.scss
 * Script - assets/js/edit/ajax/designer-edit.js
 */

// TinyMCE is loaded by HTML <script> tag. Browserify support is not finished.

var ImagePreview = require('../../view/image-preview');
var Image = require('../../model/image');
var ImageManager = require('../../view/image-manager');
var ContentEditor = require('../../view/content-editor');
var CountrySelect = require('../../view/country-select');
var CitySelect = require('../../view/city-select');
var TagSelect = require('../../view/tag-select');

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
    var coverImage = new Image({
        id: $('#image-form-group .image-preview').data('id'),
        file_urls: {
            medium: $('#image-form-group .image-preview').data('url'),
        }
    });
    var coverPreview = new ImagePreview({
        el: '#image-form-group .image-preview',
        model: coverImage,
        width: 600,
        height: 200,
        imageSize: 'medium',
    });

    $('#image-form-group button').click(function () {
        manager.call({
            multiple: false,
            done: function (image) {
                coverImage.set(_.omit(image.attributes, 'selectable', 'selected', 'progress'));
                $('#image-form-group input[type="hidden"]').val(image.get('id'));
            }

        });
    });

    var contentEditor = new ContentEditor({el: '#input-content', imageManager: manager});

    var countrySelect = new CountrySelect({el: '.country-select'});
    var citySelect = new CitySelect({el: '.city-select'});
    var tagSelect = new TagSelect({el: '.tag-select'});

    // Submit form
    $('button[type="submit"]').click(function (e) {
        e.preventDefault();

        $.ajax({
            method: 'PUT',
            url: $('#designer-edit-form').attr('action'),
            data: $('#designer-edit-form').serializeArray()
        }).done(function () {
            window.location.href = $('#designer-edit-form').attr('action');
        }).fail(function (error) {
            var response = error.responseJSON;
            var $alert = $('#designer-edit-form .alert');
            var message = '';

            for (var id in response) {
                message += '<p>' + response[id] + '</p>';
            }

            $alert.html(message).show().goTo();
        });
    });

    // Prevent unexpected form submit caused by "Enter" key press
    $('form input').keydown(function(event){
        if(event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });

});
