var Backbone = require('backbone');
var alert = require('sweetalert');
var UserSelect = require('../selects/user-select');

module.exports = Backbone.View.extend({

    el: '#transfer-modal',

    events: {
        'click .confirm-button': 'submit',
    },

    initialize: function () {
        new UserSelect({el: this.$('#user-select') });

        $(window).resize(this.positioning.bind(this));

        this.positioning();
    },

    submit: function () {
        var url = [location.protocol, '//', location.host, location.pathname].join('');
        $.ajax({
            url: url,
            method: 'patch',
            data: {
                user_id: this.$('#user-select').val(),
                _token: window.app.token,
            },
        }).done(function () {
            window.location.reload();
        }).fail(function () {
            alert("Oops...", "Something went wrong!", "error");
        });
    },

    positioning: function () {
        var margin = ($(window).height() - 300) / 2;
        this.$('.modal-dialog').css('margin-top', margin + 'px')
    }
});
