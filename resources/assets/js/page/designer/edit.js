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

    // Initialize TinyMCE
    tinymce.init({
        selector: 'textarea.tinymce',
        plugins: ['link', 'image'],
        menubar: false,
        toolbar: 'undo redo | styleselect | bold italic | link customimage',
        content_css: ['/css/app.css', '/css/editor.css'],
        setup: function (editor) {
            editor.on('change', function () {
                editor.save();
            });
            editor.addButton('customimage', {
                icon: 'image',
                onclick: function () {
                    manager.call({
                        multiple: false,
                        done: function (image) {
                            var src = image.get('file_urls').medium;
                            var size = image.size('medium');
                            var html = '<img src="' + src + '" width="' + size.width
                                + '" height="' + size.height + '">';
                            editor.insertContent(html);
                        }
                    });
                }
            });
        }
    });

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

    // Country and city select, use Select2.
    $("select#country-select").select2({theme: 'bootstrap'});
    $("select#city-select").select2({theme: 'bootstrap'});

    // Tag select, use Select2
    $("select#tag-select").select2({tags: true, theme: 'bootstrap'});
});
