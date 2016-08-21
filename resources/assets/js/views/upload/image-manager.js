/**
 * Provide a modal to upload and manage images. Select image to insert to article,
 * set cover image, avatar and so on. Can filter images belong to specifec user,
 * or page.
 */

var Backbone = require('backbone');
var sweetalert = require('sweetalert');

var ImageList = require('../../collections/image-list');
var Image = require('../../models/image');
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
        'click .ok-button': 'finishSelect',
        'click .delete-button': 'deleteSelect',
    },

    initialize: function (options) {
        _.extend(this, _.pick(options, 'parentType', 'parentId', 'my', 'fail'));

        this.collection = new ImageList();

        this.listenTo(this.collection, 'add', this.addImage);
        this.listenTo(this.collection, 'all', this.updateOkButton);
        this.listenTo(this.collection, 'all', this.updateDeleteButton);
        this.listenTo(this.collection, 'all', this.toggleNoImageAlert);

        $(window).resize(this.fitSize.bind(this));

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
        this.fitSize();
    },

    openFileBrowser: function () {
        this.$('.file-input').click();
    },

    uploadImages: function () {
        var files = this.$('.file-input')[0].files;
        for (var i = 0; i < files.length; i++) {
            var image = new Image();
            image.upload({
                image: files[i],
                parentType: this.parentType,
                parentId: this.parentId
            });
            this.collection.add(image);
        }
    },

    /**
     * When adding new image model, render preview and bind events
     */
    addImage: function (image) {
        var preview = new ImagePreview({
            model: image,
            selectable: true,
        });
        this.$('.gallery').prepend(preview.$el);

        this.listenTo(image, 'change:selected', this.unselectSiblings);
        image.set('selected', true);
    },

    unselectSiblings: function (image) {
        if (!this.multiple && image.get('selected')) {
            _.each(_.without(this.collection.models, image), function (image) {
                image.set('selected', false);
            });
        }
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

    fitSize: function () {
        var height = $(window).height() - 200;
        this.$('.modal-body').outerHeight(height);
    },

    toggleNoImageAlert: function () {
        if (this.collection.length > 0) {
            this.$('.alert').hide();
        } else {
            this.$('.alert').show();
        }
    },

    updateOkButton: function () {
        if (this.collection.where({selected: true}).length > 0) {
            this.$('.ok-button').prop('disabled', false);
        } else {
            this.$('.ok-button').prop('disabled', true);
        }
    },

    updateDeleteButton: function () {
        if (this.collection.where({selected: true}).length > 0) {
            this.$('.delete-button').show();
        } else {
            this.$('.delete-button').hide();
        }
    },

    deleteSelect: function () {
        var images = this.collection.where({selected: true});
        var html = '<br/><br/>';
        var size = 100;
        if (images.length > 3) {
            size = 50;
        }
        for (var i in images) {
            html += '<img width="' + size + '" height="' + size + '" src="' +
                    images[i].fileUrl('thumb') + '""/> ';
        }

        sweetalert({
            title: this.$('.delete-alert-title').text(),
            text: this.$('.delete-alert-text').text() + html,
            html: true,
            type: "warning",
            allowOutsideClick: true,
            showCancelButton: true,
            confirmButtonText: this.$('.delete-alert-confirm-text').text(),
            cancelButtonText: this.$('.delete-alert-cancel-text').text(),
        }, function () {
            for (var i in images) {
                images[i].destroy();
            }
        })
    },

    cancelSelect: function () {
        this.fail();
    },

    finishSelect: function () {
        var images = this.collection.where({selected: true});
        this.done(images);
        this.$el.modal('hide');
    }

});
