/**
 * Provide a modal to upload and manage images. Select image to insert to article,
 * set cover image, avatar and so on. Can filter images belong to specifec user,
 * or page.
 */

var Backbone = require('backbone');

var ImageList = require('../collection/image-list');
var Image = require('../model/image');
var ImagePreview = require('./image-preview');

module.exports = Backbone.View.extend({

    el: '#image-manager',

    multiple: false, // If can select more than one image

    max: 10, // How many images can be selected at once

    done: function () {}, // Callback after selection succeed, to be override

    fail: function () {}, // Callback after selection fail, to be override

    parentType: null, // Type of images' parent model, such as designer, place

    parentId: null, // Id of images' parent model

    previews: [], // List of sub-view ImagePreview

    my: false, // Whether fetch only my uploads

    events: {
        'click .upload-button': 'openFileBrowser',
        'change .file-input': 'uploadImages',
        'click .cancel-button': 'cancelSelect',
        'click .ok-button': 'finishSelect'
    },

    initialize: function (options) {
        _.extend(this, _.pick(options, 'parentType', 'parentId', 'my', 'fail'));

        this.collection = new ImageList();

        this.listenTo(this.collection, 'add', this.addImage);
        this.listenTo(this.collection, 'all', this.updateOkButton);

        var data = {};
        if (this.my) {
            data['my'] = true;
        } else if (typeof this.parentType === 'string' && typeof this.parentId === 'number') {
            data['parent_type'] = this.parentType;
            data['parent_id'] = this.parentId;
        }

        this.collection.fetch({
            data: data
        });
    },

    render: function () {
        return this;
    },

    call: function (options) {
        _.extend(this, _.pick(options, 'multiple', 'max', 'done', 'fail'));
        this.resetSelect();
        this.$el.modal('show');
    },

    resetSelect: function () {
        _.each(this.collection.models, function (model) {
            model.set({
                selected: false,
            });
        });
        var that = this;
        _.each(this.previews, function (preview) {
            preview.multiple = that.multiple;
        });
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
            image.upload({
                image: files[i],
                parentType: this.parentType,
                parentId: this.parentId
            });
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
        this.previews.push(preview);
        this.listenTo(preview, 'select', this.unselectSiblings);
        this.closeAlert();
    },

    unselectSiblings: function (preview) {
        _.each(_.without(this.previews, preview), function (preview) {
            preview.unselect();
        });
    },

    showAlert: function (message, type) {
        if (!type || _.contains(['success', 'info', 'warning', 'danger'], type)) {
            type = 'info';
        }
        this.$('.alert').removeClass('alert-info alert-success alert-warning alert-danger')
            .addClass('alert-').text(message).show();
    },

    closeAlert: function () {
        this.$('.alert').hide();
    },

    updateOkButton: function () {
        if (this.collection.where({selected: true}).length > 0) {
            this.$('.ok-button').prop('disabled', false);
        } else {
            this.$('.ok-button').prop('disabled', true);
        }
    },

    cancelSelect: function () {
        this.fail();
    },

    finishSelect: function () {
        var selectedImages = this.collection.where({selected: true});
        if (this.multiple) {
            this.done(selectedImages);
        } else {
            this.done(selectedImages[0]);
        }
        this.$el.modal('hide');
    }

});
