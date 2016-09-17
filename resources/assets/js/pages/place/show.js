var GallerySlider = require('../../views/gallery/gallery-slider');
var SimpleMap = require('../../views/maps/simple-map');
var DeleteButton = require('../../views/delete-button');
var LikeButton = require('../../views/like-button');
var TransferModal = require('../../views/modals/transfer-modal');


new DeleteButton();
new LikeButton();
new TransferModal();

// Gallery
new GallerySlider({el: '.gallery-slider'});


// Map
new SimpleMap({el: '.map'});
