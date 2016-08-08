var GallerySlider = require('../../views/gallery/gallery-slider');
var SimpleMap = require('../../views/maps/simple-map');
var DeleteButton = require('../../views/delete-button');
var LikeButton = require('../../views/like-button');


new DeleteButton();
new LikeButton();

// Gallery
new GallerySlider({el: '.gallery-slider'});


// Map
new SimpleMap({el: '.map'});
