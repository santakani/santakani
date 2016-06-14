var Backbone = require('backbone');
var Like = require('../model/like');

module.exports = Backbone.View.extend({

    tagName: 'a',

    className: 'like-button',

    events: {
        'click': 'like',
    },

    initialize: function () {
        if (!this.model) {
            this.model = new Like({
                likeable_type: this.$el.data('likeableType'),
                likeable_id: this.$el.data('likeableId'),
                liked: this.$el.data('liked'),
            });
        }

        this.listenTo(this.model, 'change', this.updateStatus);
    },

    like: function () {
        if (this.model.get('disabled')) {
            return;
        }

        this.model.set({
            liked: !this.model.get('liked'),
            disabled: true,
        });

        var data = {
            likeable_type: this.model.get('likeable_type'),
            likeable_id: this.model.get('likeable_id'),
            _token: csrfToken
        };

        if (!this.model.get('liked')) {
            data.dislike = true;
        }

        var that = this;

        console.log(data);

        $.ajax({
            url: '/like',
            method: 'post',
            data: data,
        }).done(function () {
            that.model.set({disabled: false});
        });
    },

    updateStatus: function () {
        if (this.model.get('liked')) {
            this.$('i').addClass('fa-heart');
            this.$('i').removeClass('fa-heart-o');
        } else {
            this.$('i').addClass('fa-heart-o');
            this.$('i').removeClass('fa-heart');
        }
        if (this.model.get('disabled')) {
            this.$el.addClass('disabled');
        } else {
            this.$el.removeClass('disabled');
        }
    }
});
