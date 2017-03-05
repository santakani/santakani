/**
 * Editor view for option row.
 */

var Backbone = require('backbone');
var Option = require('../models/option');
var Image = require('../models/image');

module.exports = module.exports = Backbone.View.extend({

    tagName: 'tr',

    className: 'option-editor',

    template: _.template($('#option-editor-template').html()),

    events: {
        'change .name-input': 'changeName',
        'change .price-add-input': 'changePriceAdd',
        'change .color-input': 'changeColor',
        'click .image-choose-button': 'chooseImage',
        'click .image-thumb': 'chooseImage',
        'click .image-remove-button': 'removeImage',
        'change .available-checkbox': 'changeAvailable',
        'click .delete-button': 'delete',
    },

    initialize: function (options) {
        _.extend(this, _.pick(options, 'imageManager', 'hasColor', 'hasImage'));

        this.listenTo(this.model, 'destroy', this.remove);
        this.listenTo(this.model, 'change:image', this.updateImage);

        this.render();
    },

    // Model --> View

    /**
     * Render DOM from temlplate
     */
    render: function () {
        this.$el.html(this.template(this.model.attributes));

        if (!this.hasColor) {
            this.$('.color-wrap').remove();
        }

        if (!this.hasImage) {
            this.$('.image-wrap').remove();
        }

        this.update();
        return this;
    },

    /**
     * Update view from model data
     */
    update: function () {
        this.$('.name-input').val(this.model.getName());
        this.$('.price-add-input').val(this.model.get('price_add'));
        this.$('.color-input').val(this.model.get('value'));
        this.$('.available-checkbox').prop("checked", this.model.get('available'));

        this.updateImage();
    },

    /**
     * Update image from model
     */
    updateImage: function () {
        if (this.model.has('image')) {
            var image = new Image(this.model.get('image'));
            if (image.id) {
                this.$('.image-thumb').attr('src', image.fileUrl('thumb'));
                this.$('.image-wrap').addClass('chosen');
                return;
            }
        } else if (this.model.has('image_id')) {
            var image = new Image({id: this.model.get('image_id')});
            var that = this;
            image.fetch({
                success: function (image) {
                    that.$('.image-thumb').attr('src', image.fileUrl('thumb'));
                    that.model.set('image', image.attributes);
                    that.$('.image-wrap').addClass('chosen');
                }
            });
            return;
        }

        // Otherwise, hide image thumbnail
        this.$('.image-wrap').removeClass('chosen');
    },

    // View --> Model

    /**
     * Read index in the list and save to model
     */
    index: function() {
        this.model.set('sort_order', this.$el.index());
        this.model.save();
    },

    changeName: function () {
        this.model.setName(this.$('.name-input').val());
        this.model.save();
    },

    changePriceAdd: function () {
        // PriceAdd must be a number, not null or NaN
        var priceAdd = parseFloat(this.$('.price-add-input').val());
        if (isNaN(priceAdd)) {
            priceAdd = 0;
            this.$('.price-add-input').val(0);
        }
        this.model.set('price_add', priceAdd);
        this.model.save();
    },

    changeColor: function () {
        this.model.set('value', this.$('.color-input').val());
        this.model.save();
    },

    chooseImage: function () {
        var that = this;
        this.imageManager.call({
            multiple: false,
            done: function (images) {
                that.model.set('image', images[0].attributes);
                that.model.set('image_id', images[0].id);
                that.model.save();
            }
        });
    },

    removeImage: function () {
        this.model.set('image_id', null);
        this.model.unset('image');
        this.model.save();
    },

    changeAvailable: function () {
        // Convert boolean to int
        this.model.set('available', + this.$('.available-checkbox').prop('checked'));
        this.model.save();
    },

    /**
     * Remove view and destroy model
     */
    delete: function () {
        this.model.destroy();
    },

});
