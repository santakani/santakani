var Backbone = require('backbone');
var Like = require('../model/like');

module.exports = Backbone.View.extend({
    el: '#like-button',

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
                like_count: parseInt(this.$el.data('likeCount')),
            });
        }

        this.listenTo(this.model, 'change', this.updateStatus);
    },

    like: function () {
        if (app.user === false) {
            $('#auth-modal').modal('show');
            return;
        }

        if (this.model.get('disabled')) {
            return;
        }

        this.model.set({
            liked: !this.model.get('liked'),
            disabled: true,
            like_count: this.model.get('liked')?this.model.get('like_count')-1:this.model.get('like_count')+1,
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
            this.$el.addClass('liked');
        } else {
            this.$el.removeClass('liked');
        }
        if (this.model.get('disabled')) {
            this.$el.addClass('disabled');
        } else {
            this.$el.removeClass('disabled');
        }

        this.$('.like-count').text(this.model.get('like_count'));
    }
});
