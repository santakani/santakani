var LikeButton = require('../../view/like-button');
var DeleteButton = require('../../view/delete-button');

$(function () {

    if($('#story-show-page').length === 0) {
        return;
    }

    // Action bar starts
    var deleteButton = new DeleteButton({
        el: '#delete-button',
    });

    var likeButton = new LikeButton({
        el: '#like-button',
    });
    // Action bar ends
});
