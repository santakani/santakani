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

    sizes: {
        large: {
            width: 1200,
            height: 1200,
            crop: false,
            fallback: 'full'
        },
        medium: {
            width: 600,
            height: 600,
            crop: false,
            fallback: 'full'
        },
        small: {
            width: 300,
            height: 300,
            crop: false,
            fallback: 'full'
        },
        thumb: {
            width: 300,
            height: 300,
            crop: true,
            fallback: false
        },
        largethumb: {
            width: 600,
            height: 600,
            crop: true,
            fallback: 'thumb'
        },
        banner: {
            width: 600,
            height: 300,
            crop: true,
            fallback: false
        },
        largebanner: {
            width: 1200,
            height: 600,
            crop: true,
            fallback: 'banner'
        }
    },

    storagePath: 'storage/images', // Related to document root

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
        data.append('_token', app.token);
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

    destroy: function () {
        return Backbone.Model.prototype.destroy.call(this, {
            data: {
                _token: app.token,
            },
            processData: true,
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

        // By default, return full size
        if (!size || size === 'full' || !_.has(this.sizes, size)) {
            return {
                width: this.get('width'),
                height: this.get('height')
            };
        }

        var sizeData = this.sizes[size];

        if (sizeData.crop) {
            // Thumbnails and banners
            return {
                width: sizeData.width,
                height: sizeData.height
            };
        } else {
            // Large, medium and small
            if (this.get('width') / this.get('height') > sizeData.width / sizeData.height) {
                return {
                    width: sizeData.width,
                    height: this.get('height') * sizeData.width / this.get('width')
                }
            } else {
                return {
                    width: this.get('width') * sizeData.height / this.get('height'),
                    height: sizeData.height
                }
            }
        }
    },

    hasSize: function (size) {

        if (size === 'full') {
            return true;
        }

        if (!_.has(this.sizes, size)) {
            return false;
        }

        var sizeData = this.sizes[size];

        if (sizeData.crop) {
            // Thumbnails and banners
            if (!sizeData.fallback) {
                return true;
            } else {
                // Fallback shouldn't be full if crop is true
                fallbackSizeData = this.sizes[sizeData.fallback];
                return this.get('width') >= fallbackSizeData.width &&
                    this.get('height') >= fallbackSizeData.height;
            }
        } else {
            // Large, medium and small
            return this.get('width') > sizeData.width || this.get('height') > sizeData.height;
        }
    },

    sizeFallback: function (size) {
        // Don't fallback if exists
        if (this.hasSize(size)) {
            return size;
        }

        // Fallback if not exists
        if (_.has(this.sizes, size)) {
            var sizeData = this.sizes[size];

            return this.sizeFallback(sizeData.fallback);
        }

        // If it doesn't match any sizes
        return 'full';
    },

    extension: function () {
        switch (this.get('mime_type')) {
            case 'image/jpeg':
                return '.jpg';
            case 'image/png':
                return '.png';
            case 'image/gif':
                return '.gif';
        };
    },

    /**
     * Generate image file urls, based on id, mime type, width and height.
     *
     * @param {string}|{object} size The size name is one of "full", "large", "medium" and "thumb".
     * @param {number} size.width
     * @param {number} size.height
     * @param {boolean} size.excludeThumb
     * @return {string} Image file URL.
     */
    fileUrl: function (size) {
        if (typeof size === 'object') {
            if (size.width > 600 || size.height > 600) {
                size = 'large';
            } else if (size.width > 300 || size.height > 300) {
                size = 'medium';
            } else if (size.excludeThumb) {
                size = 'medium';
            } else {
                size = 'thumb';
            }
        }

        var url = '/' + this.storagePath + '/';
        url += Math.floor(this.get('id')/1000) + '/';
        url += Math.floor(this.get('id')%1000) + '/';
        url += this.sizeFallback(size);
        url += this.extension();

        return url;
    },

    /**
     * Read attributes from data properties of an element.
     */
    readElement: function (element) {
        var $element = $(element);
        this.set({
            id: $element.data('id'),
            mime_type: $element.data('mime'),
            width: $element.data('width'),
            height: $element.data('height'),
        });
    },
});
