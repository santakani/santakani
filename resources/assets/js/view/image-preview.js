/**
 * Image thumbnail used for image upload, select and management.
 * Bind to model Image.
 *
 * Class: ImagePreview
 * Namespace: app.view
 */

app.view.ImagePreview = Backbone.View.extend({

    tagName: 'div',

    className: 'image-preview',

    template: _.template($('#image-preview-template').html()),

    width: 150,

    height: 150,

    selectable: false,

    selected: false,

    events: {
        'click .remove': 'remove',
        'click': 'toggleSelect'
    },

    initialize: function () {
        // Responsive size
        this.updateSize();
        $(window).resize(function () {
            preview.updateSize();
        });

        this.listenTo(this.model, 'change:progress', this.refreshProgress);
        this.listenTo(this.model, 'change:width', this.updateSize);
    },

    render: function () {
        this.$el.html(this.template(this.model.attributes));
        return this;
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

    refreshProgress: function () {
        var progress = this.model.get('progress');
        var progressBar = this.$('.progress-bar');
        if (progress === false) {
            progressBar.hide();
        } else {
            progressBar.css('width',  + '%');
            progressBar.show();
        }
    }
});
