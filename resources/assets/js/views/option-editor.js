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
        'change .value-input': 'changeValue',
        'change .image-choose-button': 'chooseImage',
        'change .image-remove-button': 'removeImage',
        'click .delete-button': 'delete',
    },

    initialize: function (options) {
        _.extend(this, _.pick(options, 'hasColor', 'hasImage', 'hasPriceAdd'));

        this.listenTo(this.model, 'destroy', this.remove);

        this.render();
    },

    // Model --> View

    /**
     * Render DOM from temlplate
     */
    render: function () {
        this.$el.html(this.template(this.model.attributes));
        this.update();
        return this;
    },

    /**
     * Update view from model data
     */
    update: function () {
        this.$('.name-input').val(this.model.getName());

        this.$('.price-add-input').val(this.model.get('price_add'));
        this.$('.value-input').val(this.model.get('value'));

        if (this.model.get('image_id')) {
            var image = new Image(this.model.get('image'));
            this.$('.image').attr('src', image.fileUrl('thumb'));
        }
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

    /**
     * Remove view and destroy model
     */
    delete: function () {
        this.model.destroy();
    },

});
