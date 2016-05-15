/**
 * Provide a modal to upload and manage images. Select image to insert to article,
 * set cover image, avatar and so on. Can filter images belong to specifec user,
 * or page.
 */

app.view.ImageManager = Backbone.View.extend({

    el: '#image-manager',

    events: {
        'click .upload-button': 'openFileBrowser',
        'change .file-input': 'uploadImages'
    },

    initialize: function () {
    },

    render: function () {
        return this;
    },

    openFileBrowser: function () {
        this.$('.file-input').click();
    },

    uploadImages: function () {
        var files = this.$('.file-input')[0].files;
        for (var i = 0; i < files.length; i++) {
            var image = new app.model.Image({id:0});
            image.upload(files[i]);
            var preview = new app.view.ImagePreview({
                model: image,
                selectable: true,
                selected: true
            });
            this.$('.gallery').prepend(preview.$el);
        }

        this.closeAlert();
    },

    closeAlert: function () {
        this.$('.alert').hide();
    }

});

$('#image-manager').modal('show');

var manager = new app.view.ImageManager;
