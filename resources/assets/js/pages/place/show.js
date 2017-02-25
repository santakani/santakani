var SimpleMap = require('../../views/maps/simple-map');
var DeleteButton = require('../../views/delete-button');
var LikeButton = require('../../views/like-button');
var TransferModal = require('../../views/modals/transfer-modal');
var Place = require('../../models/place');


new DeleteButton({el: '#delete-button'});
new DeleteButton({el: '#force-delete-button', forceDelete: true});
new LikeButton();
new TransferModal();

// Gallery
$('.images').lightGallery();


// Map
new SimpleMap({
    el: '.simple-map',
    model: new Place($('.simple-map').data('model'))
});

function resizeMap() {
    $('.map').height($('.cover').height());
}

resizeMap();

$(window).resize(resizeMap);
