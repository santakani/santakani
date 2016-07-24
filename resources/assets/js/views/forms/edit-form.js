var Backbone = require('backbone');
var sweetalert = require('sweetalert');

module.exports = Backbone.View.extend({

    el: '#edit-form',

    events: {
        'click button[type="submit"]': 'submit',
        'keydown input': 'preventEnterSubmit',
    },

    initialize: function () {
        this.lock();
        this.lockInterval = setInterval(this.lock.bind(this), 60000);
    },

    lock: function () {
        var that = this;
        $.ajax({
            method: 'patch',
            url: this.$el.attr('action'),
            data: {
                lock: true,
                _token: app.token,
            }
        }).fail(function (jqXHR, textStatus, errorThrown) {
            clearInterval(that.lockInterval);
            if (jqXHR.status === 423) {
                sweetalert({
                    title: "Locked",
                    text: "The page is editing by others. Please try later.",
                    type: "warning",
                },
                function(){
                    that.back();
                });
            } else {
                sweetalert({
                    title: "Oops...",
                    text: "Something went wrong!",
                    type: "error",
                },
                function(){
                    that.back();
                });
            }
        });
    },

    submit: function (e) {
        e.preventDefault();
        var that = this;
        $.ajax({
            method: 'patch',
            url: this.$el.attr('action'),
            data: this.$el.serialize()
        }).done(function (data, textStatus, jqXHR) {
            that.back();
        }).fail(function (jqXHR, textStatus, errorThrown) {
            if (jqXHR.status === 422) {
                that.renderErrors(jqXHR.responseJSON);
            } else {
                sweetalert("Oops...", "Something went wrong!", "error");
            }
        });
    },

    preventEnterSubmit: function (e) {
        if(e.keyCode == 13) {
            e.preventDefault();
            return false;
        }
    },

    clearErrors: function () {
        this.$('.form-group').removeClass('has-error');
        this.$('.help-block').remove();
    },

    renderErrors: function (errors) {
        this.clearErrors();
        for (var name in errors) {
            var $formGroup = this.$('[name="' + name +'"]').parents('.form-group');
            $formGroup.addClass('has-error');
            var message = '';
            if (typeof errors[name] === 'string') {
                message = errors[name];
            } else if (typeof errors[name] === 'object') {
                message = errors[name][0];
            }
            $formGroup.append('<span class="help-block">' + message + '</span>' );
        }
        $(window).scrollTo('.has-error', 300, {offset: -100});
    },

    back: function () {
        location.href = this.$el.attr('action');
    },

});
