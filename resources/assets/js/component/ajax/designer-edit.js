/**
 * Control designer edit form.
 *
 * View - views/designer/edit.blade.php
 * Style - assets/sass/_edit-layout.scss
 * Script - assets/js/edit/ajax/designer-edit.js
 */

$(function () {

    // Page check
    if ($('#designer-edit-page').length === 0) {
        return;
    }

    // Initialize TinyMCE
    tinymce.init({
        selector: 'textarea.tinymce',
        menubar: false,
        content_css: '/css/app.css',
        setup: function (editor) {
            editor.on('change', function () {
                editor.save();
            });
        }
    });

    // Initialize ImageUploaders
    var imagePreview = new ImagePreview({
        selector: '#image-form-group .image-preview'
    });

    var imageUploader = new ImageUploader({
        selector: '#image-form-group .image-uploader',
        start: function () {
            imagePreview.progress('show');
        },
        progress: function (percentage) {
            imagePreview.progress(percentage);
        },
        done: function (image) {
            imagePreview.progress('hide');
            imagePreview.image(image.id, image.url.thumb);
        },
        fail: function (error) {
            imagePreview.progress('hide');
            console.log(error);
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
    $("select#country-select").select2();
    $("select#city-select").select2();

    // Tag select, use Select2
    $("select#tag-select").select2({tags: true});
});
