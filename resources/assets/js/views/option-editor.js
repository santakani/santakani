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
        'click .delete-button': 'delete',
    },

    initialize: function (options) {
        _.extend(this, _.pick(options, 'hasColor', 'hasImage', 'hasPriceAdd'));

        this.listenTo(this.model, 'destroy', this.remove);

        this.render();
    },

    render: function () {
        this.$el.html(this.template(this.model.attributes));
        this.update();
        return this;
    },

    update: function () {
        this.$('.name-input').val(this.model.getName());

        this.$('.price-add-input').val(this.model.get('price_add'));
        this.$('.value-input').val(this.model.get('value'));

        if (this.model.get('image_id')) {
            var image = new Image(this.model.get('image'));
            this.$('.image').attr('src', image.fileUrl('thumb'));
        }
    },

    delete: function () {
        this.model.destroy();
    },

});
