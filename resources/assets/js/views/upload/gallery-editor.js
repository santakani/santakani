/**
 * Manage image gallery shown on pages. It is different from ImageManager, which
 * manage all images uploaded into the parent page. In gallery editor, users can
 * choose which images should be shown and change their orders.
 */

var Backbone = require('backbone');
var Sortable = require('sortablejs');

var Image = require('../../models/image');
var ImagePreview = require('./image-preview');

module.exports = Backbone.View.extend({

    el: '#gallery-editor',

    events: {
        'click button': 'openImageManager'
    },

    initialize: function (options) {
        _.extend(this, _.pick(options, 'imageManager'));

        this.$('.image-preview').each(function () {
            var preview = new ImagePreview({
                el: this,
                inputName: 'gallery_image_ids[]',
                removeable: true,
            });
        });

        Sortable.create(this.$('.images')[0], {
            animation: 300,
        });

    },

    openImageManager: function () {
        var that = this;

        this.imageManager.call({
            multiple: true,
            done: function (images) {
                _.each(images, function (image) {
                    var preview = new ImagePreview({
                        model: image,
                        inputName: 'gallery_image_ids[]',
                        removeable: true,
                    });
                    that.$('.images').append(preview.$el);
                }, this);
            }
        });
    },

});
