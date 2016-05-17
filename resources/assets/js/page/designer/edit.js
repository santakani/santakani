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

$(function () {

    // Page check
    if ($('#designer-edit-page').length === 0) {
        return;
    }

    // Image manager
    var manager = new ImageManager({
        parentType: 'designer',
        parentId: 1
    });

    $('.upload-button').click(function () {
        manager.call();
    });

    // Initialize TinyMCE
    tinymce.init({
        selector: 'textarea.tinymce',
        menubar: false,
        content_css: ['/css/app.css', '/css/editor.css'],
        setup: function (editor) {
            editor.on('change', function () {
                editor.save();
            });
        }
    });



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
