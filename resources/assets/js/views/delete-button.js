var Backbone = require('backbone');
var swal = require('sweetalert');

module.exports = Backbone.View.extend({

    el: '#delete-button',

    url: location.pathname,

    redirect: '/', // Set false if do not want redirect after delete.

    events: {
        'click': 'delete',
    },

    initialize: function (options) {
        _.extend(this, _.pick(options, 'url', 'redirect'));
    },

    delete: function (e) {
        e.preventDefault();
        var that = this;
        swal({
            title: "Confirm Delete",
            text: 'Deleted page can be restored in your <a href="/setting">account setting</a> page.',
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
            $.ajax({
                url: that.url,
                method: 'delete',
                data: {
                    _token: app.token
                }
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
