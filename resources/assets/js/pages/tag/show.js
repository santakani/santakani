var LikeButton = require('../../views/like-button');
var DeleteButton = require('../../views/delete-button');

$(function () {

    if($('#tag-show-page').length === 0) {
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
