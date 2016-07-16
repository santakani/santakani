var Backbone = require('backbone');

var Image = require('../../models/image');

module.exports = Backbone.View.extend({

    tagName: 'div',

    className: 'image-chooser',

    events: {
        'click': 'choose'
    },

    // Default options
    width: 150,

    height: 150,

    inputName: 'image_id',

    initialize: function (options) {
        _.extend(this, options);

        if (typeof this.model === 'undefined') {
            this.model = new Image(this.$el.data('model'));
        }

        this.update();

        var that = this;
        $(window).resize(function () {
            that.update();
        });

        this.listenTo(this.model, 'change', this.update);
    },

    update: function () {
        // Update size
        this.$el.width(this.width);
        var realWidth = this.$el.width();
        var realHeight = this.height * realWidth / this.width;
        this.$el.height(realHeight);

        // Update image
        if (this.model.get('id')) {
            var size = {
                width: realWidth,
                height: realHeight,
            };
            this.$el.css('background-image', 'url(' + this.model.fileUrl(size) + ')');
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
