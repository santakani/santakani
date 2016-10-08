var Backbone = require('backbone');

module.exports = Backbone.View.extend({
    el: '#page-content',

    initialize: function () {
        this.$el.lightGallery({
            selector: this.$el.find('a > img').parent(),
            download: false,
            getCaptionFromTitleOrAlt: false,
        });

        this.initLinks();
        this.initMedia();
    },

    initLinks: function () {
        this.$('a').each(function () {
            console.log(this.hostname);
            if (this.hostname && this.hostname !== location.hostname) {
                this.target = '_blank';
            }
        });
    },

    initMedia: function () {
        this.$('iframe').each(function () {
            $(this).attr('frameborder', 0);
            $(this).attr('allowfullscreen', 'allowfullscreen');
        });

        this.resizeMedia();
        var that = this;
        $(window).resize(function () {
            that.resizeMedia();
        });
    },

    resizeMedia: function () {
        var that = this;
        this.$('iframe').each(function () {
            $(this).width(that.$el.width());
            $(this).height(that.$el.width() * 9 / 16);
        });
    }
});
