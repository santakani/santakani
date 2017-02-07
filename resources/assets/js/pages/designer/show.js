var LikeButton = require('../../views/like-button');
var EditorPickButton = require('../../views/actions/editor-pick-button');
var DeleteButton = require('../../views/delete-button');
var PageContent = require('../../views/content/page-content');
var TransferModal = require('../../views/modals/transfer-modal');


// Action buttons
new LikeButton();
new EditorPickButton();
new DeleteButton({el: '#delete-button'});
new DeleteButton({el: '#force-delete-button', forceDelete: true});

// Gallery
$('#gallery').lightGallery({
    selector: 'a',
});

new PageContent();

new TransferModal();
