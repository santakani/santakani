/**
 * Manage image gallery shown on pages. It is different from ImageManager, which
 * manage all images uploaded into the parent page. In gallery editor, users can
 * choose which images should be shown and change their orders.
 */

var Backbone = require('backbone');
var Sortable = require('sortablejs');

var Image = require('../../models/image');
var ImageList = require('../../collections/image-list');
var ImagePreview = require('./image-preview');

module.exports = Backbone.View.extend({

    el: '#gallery-editor',

    events: {
        'click button': 'chooseImage'
    },

    inputName: 'gallery_image_ids[]',

    initialize: function (options) {
        _.extend(this, _.pick(options, 'imageManager', 'inputName'));

        this.collection = new ImageList();

        // Bind events
        this.listenTo(this.collection, 'add', this.addImage);
        this.listenTo(this.imageManager.collection, 'remove', this.checkExistence);

        // Initialize images and add to collection
        var that = this;
        this.$('.image-preview').each(function () {
            var image = new Image($(this).data('model'));
            $(this).remove();
            that.collection.add(image);
        });

        // Drag and sort
        Sortable.create(this.$('.images')[0], {
            animation: 300,
        });
    },

    chooseImage: function () {
        var that = this;

        this.imageManager.call({
            multiple: true,
            done: function (images) {
                _.each(images, function (image) {
                    if (!that.collection.get(image)) {
                        that.collection.add(image.clone());
                    }
                });
            }
        });
    },

    /**
     * When adding new image model, create an image preview and bind events.
     *
     * @param image Image model added to collection
     */
    addImage: function (image) {
        var preview = new ImagePreview({
            model: image,
            inputName: this.inputName,
            removeable: true,
        });

        this.$('.images').append(preview.$el);

        this.listenTo(preview, 'remove', this.removeImage);
    },

    /**
     * When removed an image preview, also remove the model from collection.
     *
     * @param preview ImagePreview removed
     */
    removeImage: function (preview) {
        this.collection.remove(preview.model);
    },

    /**
     * Fire when image models were removed from image manager. If chosen images
     * was deleted from image manager, remove them from gallery.
     */
    checkExistence: function () {
        this.collection.each(function (image) {

            if (!this.imageManager.collection.get(image)) {
                image.trigger('destroy'); // Remove image preview, do not send DELETE
                this.collection.remove(image);
            }
        }, this);
    }
});
