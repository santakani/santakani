var Backbone = require('backbone');

var Image = require('../../models/image');

module.exports = Backbone.View.extend({

    tagName: 'div',

    className: 'image-chooser',

    template: _.template('<button type="button"><i class="fa fa-camera"></i> Choose image</button><input type="hidden"/>'),

    events: {
        'click': 'choose'
    },

    // Default options
    width: 150,

    height: 150,

    inputName: 'image_id',

    initialize: function (options) {
        _.extend(this, options);

        if (!this.$el.html()) {
            this.render();
        }

        if (typeof this.model === 'undefined') {
            this.model = new Image();
            this.model.readElement(this.el);
        }

        this.update();

        var that = this;
        $(window).resize(function () {
            that.update();
        });

        this.listenTo(this.model, 'change', this.update);
    },

    render: function () {
        this.$el.html(this.template());
        this.$el.addClass(this.className);
        this.$('input').attr('name', this.inputName);
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
            this.$el.css('background-image', 'url(' + this.model.url(size) + ')');
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
            done: function (image) {
                that.model.set(image.attributes);
            }
        });
    }
});
