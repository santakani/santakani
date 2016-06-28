var LikeButton = require('../../views/like-button');
var DeleteButton = require('../../views/delete-button');


// Action buttons
var likeButton = new LikeButton();
var deleteButton = new DeleteButton();

$('#main-tabs a').click(function (e) {
    e.preventDefault();
    $(this).tab('show');
});


// Gallery
$('#gallery').lightGallery({
    selector: 'a',
});
