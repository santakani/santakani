/**
 * Class: ImageModel
 *
 * See https://github.com/santakani/santakani.com/wiki/Models#image
 */
var Backbone = require('backbone');

module.exports = Backbone.Model.extend({

    defaults: {
        'progress': false, // Upload progress. Uploading: int, 0-100(%); uploaded: false.
        'selectable': false,
        'selected': false
    },

    urlRoot: '/image',

    largeSize: 1200,

    mediumSize: 600,

    thumbSize: 300,

    imageStoragePath: 'storage/image', // Related to document root

    /**
     * Upload image file. If succeed, new image model created on server and return
     * to client.
     *
     * @param {Object} options
     * @param {File}   options.image Image file from a file input.
     * @param {string} options.parent_type Parent page type, like 'designer', 'place'.
     * @param {number} options.parent_id Parent page id.
     */
    upload: function (options) {
        var that = this;

        var data = new FormData();
        data.append('_token', csrfToken);
        data.append('image', options.image);

        if (typeof options.parentType === 'string' && typeof options.parentId === 'number') {
            data.append('parent_type', options.parentType);
            data.append('parent_id', options.parentId);
        }

        $.ajax({
            method: 'POST',
            url: '/image',
            data: data,
            processData: false,
            contentType: false,
            dataType: 'json',
            xhr: function() {
                var xhr = new window.XMLHttpRequest();

                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        percentComplete = parseInt(percentComplete * 100);
                        that.set({progress: percentComplete});
                    }
                }, false);

                return xhr;
            }
        }).done(function (data) {
            that.set(data);
            that.set({progress: false});
        }).fail(function (error) {
            console.log(error);
        });
    },

    /**
     * Calculate actual width and height of different image sizes. Return an object
     * like {width: 1200, height: 900}
     *
     * @param {string} size The size name is one of "full", "large", "medium" and "thumb".
     * @return {Object} Object with width and height properties.
     */
    size: function (size) {
        var width, height;

        if (size === 'large') {
            if (this.get('width') <= 1200 && this.get('height') <= 1200) {
                width = this.get('width');
                height = this.get('height');
            } else if (this.get('width') >= this.get('height')) {
                width = 1200;
                height = Math.round(1200 * this.get('height') / this.get('width'));
            } else {
                width = Math.round(1200 * this.get('width') / this.get('height'));
                height = 1200;
            }
        } else if (size === 'medium') {
            if (this.get('width') <= 600 && this.get('height') <= 600) {
                width = this.get('width');
                height = this.get('height');
            } else if (this.get('width') >= this.get('height')) {
                width = 600;
                height = Math.round(600 * this.get('height') / this.get('width'));
            } else {
                width = Math.round(600 * this.get('width') / this.get('height'));
                height = 600;
            }
        } else if (size === 'thumb') {
            if (this.get('width') >= 300 && this.get('height') >= 300) {
                width = 300;
                height = 300;
            } else {

            }
        } else {
            width = this.get('width');
            height = this.get('height');
        }

        return {width: width, height: height};
    },

    /**
     * Generate image file urls, based on id, mime type, width and height.
     * @param {string} size The size name is one of "full", "large", "medium" and "thumb".
     * @return {string} Image file URL.
     */
    fileUrl: function (size) {
        var url = '/' + this.imageStoragePath + '/';
        url += Math.floor(this.get('id')/1000) + '/';
        url += Math.floor(this.get('id')%1000) + '/';

        if (size === 'large' && this.get('width') >= this.largeSize && this.get('height') >= this.largeSize) {
            url += 'large';
        } else if (size === 'medium' && this.get('width') >= this.mediumSize && this.get('height') >= this.mediumSize) {
            url += 'medium';
        } else if (size === 'thumb') {
            url += 'thumb';
        } else {
            url += 'full';
        }

        switch (this.get('mime_type')) {
            case 'image/jpeg':
                url += '.jpg';
                break;
            case 'image/png':
                url += '.png';
                break;
            case 'image/gif':
                url += '.gif';
                break;
        };

        return url;
    },
});
