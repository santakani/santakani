var Backbone = require('backbone');

module.exports = Backbone.View.extend({

    initialize: function (options) {
        _.extend(this, _.pick(options, 'imageManager'));

        if (!this.$el.attr('id')) {
            this.$el.attr('id', 'content-editor-' + Math.floor(Math.random() * 10000));
        }

        this.selector = '#' + this.$el.attr('id');

        var that = this;

        // Initialize TinyMCE
        tinymce.init({
            selector: this.selector,
            plugins: ['link', 'image'],
            menubar: false,
            toolbar: 'undo redo | styleselect | bold italic | link customimage',
            content_css: ['/css/app.css', '/css/editor.css'],
            convert_urls: false, // Do not convert absolute URLs
            setup: function (editor) {
                editor.on('change', function () {
                    editor.save();
                });
                editor.addButton('customimage', {
                    icon: 'image',
                    onclick: function () {
                        that.imageManager.call({
                            multiple: false,
                            done: function (image) {
                                var id = image.get('id');
                                var src = image.fileUrl('medium');
                                var largeUrl = image.fileUrl('large');
                                var size = image.size('medium');
                                var html = '<a href="' + largeUrl + '"><img src="'
                                    + src + '" width="' + size.width + '" height="'
                                    + size.height + '" alt="Image ' + id + '"></a>';
                                editor.insertContent(html);
                            }
                        });
                    }
                });
            }
        });
    }
});
