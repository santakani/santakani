var Image = require('../../models/image');
var ImagePreview = require('../../views/image-preview');
var ImageManager = require('../../views/image-manager');

(function () {

    if ($('#tag-edit-page').length === 0) { return; }

    // Image manager
    var manager = new ImageManager({
        parentType: 'tag',
        parentId: parseInt($('form').data('id'))
    });

    // Translation Tabs
    $('#translation-tabs a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });

    // Cover Image
    var coverPreview = new ImagePreview({
        el: '.cover-editor .image-preview',
        inputName: 'image_id',
    });

    $('.cover-editor button').click(function () {
        manager.call({
            multiple: false,
            done: function (image) {
                coverPreview.model.set(image.attributes);
            }
        });
    });

    // Submit form
    $('button[type="submit"]').click(function (e) {
        e.preventDefault();

        var $form = $('#tag-edit-form');
        var $alert = $form.find('.alert');

        $.ajax({
            method: 'PUT',
            url: $form.attr('action'),
            data: $form.serializeArray()
        }).done(function () {
            window.location.href = $form.attr('action');
        }).fail(function (error) {
            var response = error.responseJSON;

            var messages = '';

            for (var id in response) {
                messages += '<p>' + response[id] + '</p>';
            }

            $alert.html(messages).show().scrollTo(100);
        });
    });

})();
