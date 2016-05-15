/**
 * Class: Image
 *
 * Namespace: app.model
 *
 * See https://github.com/santakani/santakani.com/wiki/Models#image
 */

app.model.Image = Backbone.Model.extend({

    defaults: {
        'progress': false, // Upload progress. Uploading: int, 0-100(%); uploaded: false.
    },

    urlRoot: '/image',

    upload: function (image) {
        var that = this;

        if (image === undefined) {
            if (this.image === undefined) {
                var image = this.image;
            } else {
                var image = null;
            }
        }

        var data = new FormData();
        data.append('_token', csrfToken);
        data.append('image', image);

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
        }).fail(function (data) {
            console.log(data);
        });
    }
});
