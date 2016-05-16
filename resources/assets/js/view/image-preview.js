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

    selectable: false,

    selected: false,

    events: {
        'click .remove': 'remove',
        'click': 'toggleSelect'
    },

    initialize: function (options) {
        _.extend(this, _.pick(options, 'width', 'height', 'selectable', 'selected'));

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
        if (this.selected) {
            this.$el.addClass('selected');
        }
        this.update();
        return this;
    },

    update: function () {
        this.updateImage();
        this.updateSize();
        this.updateProgress();
    },

    updateSize: function () {
        this.$el.css('width', this.width + 'px'); // max-width controlled by CSS.
        this.$el.css('height', this.$el.width() * this.height / this.width);
    },

    toggleSelect: function () {
        if (!this.selectable) {
            return;
        }

        this.selected = !this.selected;

        if (this.selected) {
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
            url = this.model.get('file_urls')['thumb'];
        }
        this.$el.css('background-image', 'url(' + url + ')');
    }
});
