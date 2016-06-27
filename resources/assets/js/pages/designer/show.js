var LikeButton = require('../../views/like-button');
var DeleteButton = require('../../views/delete-button');


// Action buttons
var likeButton = new LikeButton();
var deleteButton = new DeleteButton();


// Gallery
$('.gallery').lightGallery({
    thumbWidth: 100,
    thumbContHeight: 120
});
