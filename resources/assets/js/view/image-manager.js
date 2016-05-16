/**
 * Provide a modal to upload and manage images. Select image to insert to article,
 * set cover image, avatar and so on. Can filter images belong to specifec user,
 * or page.
 */

var ImageList = require('../collection/image-list');
var Image = require('../model/image');
var ImagePreview = require('./image-preview');

module.exports = Backbone.View.extend({

    el: '#image-manager',

    events: {
        'click .upload-button': 'openFileBrowser',
        'change .file-input': 'uploadImages'
    },

    initialize: function (options) {
        _.extend(this, _.pick(options, 'width', 'height', 'selectable', 'selected'));

        this.collection = new ImageList();
        this.listenTo(this.collection, 'add', this.addImage);
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
            var image = new Image({
                id: 0,
                selectable: true,
                selected: true
            });
            image.upload(files[i]);
            this.collection.add(image);
        }
    },

    /**
     * Fetch uploaded images from server.
     */
    addImage: function (image) {
        image.set({
            selectable: true,
            selected: true
        });
        var preview = new ImagePreview({model: image});
        this.$('.gallery').prepend(preview.$el);
        this.closeAlert();
    },

    closeAlert: function () {
        this.$('.alert').hide();
    }

});
