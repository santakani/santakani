var LikeButton = require('../../views/like-button');
var DeleteButton = require('../../views/delete-button');
var PageContent = require('../../views/content/page-content');
var TransferModal = require('../../views/modals/transfer-modal');


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

new PageContent();

new TransferModal();
