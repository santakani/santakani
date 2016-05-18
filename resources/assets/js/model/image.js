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
    }
});
