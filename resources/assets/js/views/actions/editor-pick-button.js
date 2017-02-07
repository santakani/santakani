var Backbone = require('backbone');
var swal = require('sweetalert');

module.exports = Backbone.View.extend({

    el: '#editor-pick-button',

    url: location.pathname,

    events: {
        'click': 'toggle',
    },

    initialize: function (options) {
        _.extend(this, _.pick(options, 'url'));
    },

    toggle: function (e) {
        e.preventDefault();
        var that = this;

        if (this.$el.hasClass('picked')) {
            swal({
                title: "Remove Editor's Pick",
                text: "Editor's Pick are featured designers, designs and places that worth recommandation.",
                type: "warning",
                showCancelButton: true,
                allowOutsideClick: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
            },
            function(){
                var data = {
                    editor_pick: 0,
                    _token: app.token
                };
                $.ajax({
                    url: that.url,
                    method: 'patch',
                    data: data
                }).done(function () {
                    swal("Success", "Successfully removed Editor's Pick", "success");
                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);
                }).fail(function () {
                    swal("Error", "Cannot remove editor's pick.", "error");
                });
            });
        } else {
            swal({
                title: "Set Editor's Pick",
                 text: "Editor's Pick are featured designers, designs and places that worth recommandation.",
                 type: "info",
                 showCancelButton: true,
                 allowOutsideClick: true,
                 closeOnConfirm: false,
                 showLoaderOnConfirm: true,
            },
            function(){
                var data = {
                    editor_pick: 1,
                    _token: app.token
                };
                $.ajax({
                    url: that.url,
                    method: 'patch',
                    data: data
                }).done(function () {
                    swal("Success", "Successfully set Editor's Pick", "success");
                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);
                }).fail(function () {
                    swal("Error", "Cannot set editor's pick.", "error");
                });
            });
        }

        this.$el.toggleClass('picked');
    },
});
