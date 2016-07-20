var Backbone = require('backbone');

var Image = require('../../models/image');

module.exports = Backbone.View.extend({

    tagName: 'div',

    className: 'image-chooser',

    events: {
        'click': 'choose'
    },

    initialize: function (options) {
        _.extend(this, options);

        if (typeof this.model === 'undefined') {
            this.model = new Image(this.$el.data('model'));
        }

        this.size = this.$el.data('size');

        this.update();

        this.listenTo(this.model, 'change', this.update);
    },

    update: function () {
        // Update image
        if (this.model.get('id')) {
            this.$el.css('background-image', 'url(' + this.model.fileUrl(this.size) + ')');
        } else {
            this.$el.css('background-image', 'none');
        }

        // Update input
        this.$('input').val(this.model.get('id'));
    },

    choose: function () {
        var that = this;
        this.manager.call({
            multiple: false,
            done: function (images) {
                that.model.set(images[0].attributes);
            }
        });
    }
});
