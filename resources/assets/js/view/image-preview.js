/**
 * Image thumbnail used for image upload, select and management.
 * Bind to model Image.
 *
 * Class: ImagePreview
 */

var tpl = require('../utility/template');

module.exports = Backbone.View.extend({

    tagName: 'div',

    className: 'image-preview',

    template: _.template(tpl.load('#image-preview-template')),

    width: 150,

    height: 150,

    imageSize: 'thumb',

    removeable: false,

    multiple: false, // true: select like checkbox; false: select like radio button

    events: {
        'click .remove': 'remove',
        'click': 'select'
    },

    initialize: function (options) {
        _.extend(this, _.pick(options, 'width', 'height', 'imageSize', 'removeable', 'multiple'));

        this.render();

        // Responsive size
        this.updateSize();
        $(window).resize(function () {
            preview.updateSize();
        });

        this.listenTo(this.model, 'change', this.update);
    },

    render: function () {
        this.$el.html(this.template(this.model.attributes));
        this.update();
        return this;
    },

    update: function () {
        if (this.removeable) {
            this.$('.remove').show();
        } else {
            this.$('.remove').hide();
        }

        this.updateImage();
        this.updateSize();
        this.updateSelect();
        this.updateProgress();
    },

    updateSize: function () {
        this.$el.css('width', this.width + 'px'); // max-width controlled by CSS.
        this.$el.css('height', this.$el.width() * this.height / this.width);
    },

    select: function () {
        if (this.multiple) {
            this.model.set({selected: !this.model.get('selected')});
        } else {
            this.model.set({selected: true});
            this.trigger('select', this);
        }
    },

    unselect: function () {
        this.model.set({selected: false});
    },

    updateSelect: function () {
        if (!this.model.get('selectable')) {
            return;
        }

        if (this.model.get('selected')) {
            this.$el.addClass('selected');
        } else {
            this.$el.removeClass('selected');
        }
    },

    updateProgress: function () {
        var progress = this.model.get('progress');
        if (progress === false) {
            this.$('.progress').hide();
        } else {
            this.$('.progress-bar').css('width', progress + '%');
            this.$('.progress').show();
        }
    },

    updateImage: function () {
        var url = '';
        if (this.model.get('file_urls')) {
            url = this.model.get('file_urls')[this.imageSize];
        }
        this.$el.css('background-image', 'url(' + url + ')');
    }
});
