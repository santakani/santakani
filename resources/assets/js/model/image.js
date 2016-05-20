/**
 * Class: ImageModel
 *
 * See https://github.com/santakani/santakani.com/wiki/Models#image
 */

module.exports = Backbone.Model.extend({

    defaults: {
        'progress': false, // Upload progress. Uploading: int, 0-100(%); uploaded: false.
        'selectable': false,
        'selected': false
    },

    urlRoot: '/image',

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
    }
});
