/**
 * Visual editor for HTML editing. Use TinyMCE.
 *
 * @see https://github.com/santakani/santakani.com/wiki/Visual-Editor:-TinyMCE
 */

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

            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen hr toc textcolor',
                'insertdatetime media table contextmenu paste code'
            ],

            menubar: false,
            statusbar: false,
            toolbar1: 'bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | link unlink customimage media hr',
            toolbar2: 'undo redo | styleselect forecolor backcolor  | pastetext removeformat | toc charmap table insertdatetime | fullscreen',

            language: app.locale,

            height: 400,
            min_height: 300,
            max_height: 600,

            content_css: [$('#app-css').attr('href')],

            convert_urls: false, // Keep relative URLs for images and links

            // Link plugin options
            target_list: false,
            link_title: false,

            // Image plugin options
            image_description: false, // This is the alt="" property, only for accessibility

            // Media plugin options
            media_alt_source: false,
            media_dimensions: false,
            media_poster: false,

            setup: function (editor) {
                editor.on('change', function () {
                    editor.save();
                });
                editor.addButton('customimage', {
                    tooltip: 'Insert/edit image',
                    icon: 'image',
                    onclick: function () {
                        that.imageManager.call({
                            multiple: true,
                            done: function (images) {
                                for (var i = 0; i < images.length; i++) {
                                    var image = images[i];
                                    var src = image.fileUrl('medium');
                                    var largeUrl = image.fileUrl('large');
                                    var size = image.size('medium');
                                    var html = '<p><a href="' + largeUrl + '"><img src="'
                                        + src + '" width="' + size.width + '" height="'
                                        + size.height + '" alt="Image"></a></p>';
                                    editor.insertContent(html);
                                }
                            }
                        });
                    }
                });
            }
        });
    }
});
