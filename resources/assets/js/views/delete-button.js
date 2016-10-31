var Backbone = require('backbone');
var swal = require('sweetalert');

module.exports = Backbone.View.extend({

    el: '#delete-button',

    url: location.pathname,

    redirect: '/', // Set false if do not want redirect after delete.

    forceDelete: false,

    events: {
        'click': 'delete',
    },

    initialize: function (options) {
        _.extend(this, _.pick(options, 'url', 'redirect', 'forceDelete'));
    },

    delete: function (e) {
        e.preventDefault();
        var that = this;

        var deleteMessage;
        if (that.forceDelete) {
            deleteMessage = 'Deleted page can NOT be restored!';
        } else {
            deleteMessage = 'Deleted page can be restored in <strong><a href="/trash">Trash</a></strong> page.';
        }

        swal({
            title: "Confirm Delete",
            text: deleteMessage,
            type: "warning",
            html: true,
            showCancelButton: true,
            closeOnConfirm: false,
            allowOutsideClick: true,
            showLoaderOnConfirm: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel please!",
        },
        function(){
            var data = {
                _token: app.token
            };
            if (that.forceDelete) {
                data.action = 'force_delete';
            }
            $.ajax({
                url: that.url,
                method: 'delete',
                data: data
            }).done(function () {
                swal("Deleted");
                setTimeout(function () {
                    if (that.redirect) {
                        window.location = that.redirect;
                    }
                }, 1000);
            }).fail(function () {
                swal("Cannot delete this page.");
            });
        });
    },
});
