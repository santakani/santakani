var LikeButton = require('../../views/like-button');
var DeleteButton = require('../../views/delete-button');


// Action buttons
var likeButton = new LikeButton();
var deleteButton = new DeleteButton();

$('.nav-tabs a').click(function (e) {
    e.preventDefault();
    $(this).tab('show');
});


// Gallery
$('.gallery').lightGallery({
    thumbWidth: 100,
    thumbContHeight: 120
});
