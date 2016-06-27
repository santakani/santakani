/**
 * Story edit form.
 */

var Image = require('../../models/image');

var ImagePreview = require('../../views/image-preview');
var ImageManager = require('../../views/image-manager');
var ContentEditor = require('../../views/content-editor');
var TagSelect = require('../../views/tag-select');

$(function () {

    // Page check
    if ($('#story-edit-page').length === 0) {
        return;
    }

    // Image manager
    var manager = new ImageManager({
        parentType: 'story',
        parentId: parseInt($('form').data('id'))
    });

    // Translation Tabs
    $('#translation-tabs > li:not(.dropdown) > a, #translation-tabs ul a').click(function (e) {
        e.preventDefault();
        if (!$(this).hasClass('more')) {
            $(this).tab('show');
        }
    });

    $('.content-editor').each(function () {
        new ContentEditor({el: this, imageManager: manager});
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
                coverPreview.model.set(image.attributes);
            }
        });
    });

    var tagSelect = new TagSelect({el: '.tag-select'});

    // Submit form
    $('button[type="submit"]').click(function (e) {
        e.preventDefault();

        $.ajax({
            method: 'PUT',
            url: $('#story-edit-form').attr('action'),
            data: $('#story-edit-form').serializeArray()
        }).done(function () {
            window.location.href = $('#story-edit-form').attr('action');
        }).fail(function (error) {
            var response = error.responseJSON;
            var $alert = $('#story-edit-form .alert');
            var message = '';

            for (var id in response) {
                message += '<p>' + response[id] + '</p>';
            }

            $alert.html(message).show().scrollTo();
        });
    });

});
