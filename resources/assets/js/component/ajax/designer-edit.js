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

    // Initialize ImageUploader for main image
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

    // Initialize ImageUploader for image gallery
    $('#gallery-form-group .image-gallery .image-preview').each(function () {
        var preview = new ImagePreview({
            element: this
        });
    });

    Sortable.create($('.image-gallery')[0], {animation: 300});

    var newPreviews = [];

    var galleryUploader = new ImageUploader({
        selector: '#gallery-form-group .image-uploader',
        multiple: true,
        start: function (index) {
            var preview = new ImagePreview({
                template: $($('#gallery-form-group template').prop('content')).find('.image-preview')
            });
            $('.image-gallery').append(preview.element);
            preview.progress('show');
            newPreviews.push(preview);
        },
        progress: function (percentage, index) {
            newPreviews[index].progress(percentage);
        },
        done: function (image, index) {
            newPreviews[index].progress('hide');
            newPreviews[index].image(image.id, image.url.thumb);
            console.log(index);
        },
        fail: function (error, index) {
            newPreviews[index].progress('hide');
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
