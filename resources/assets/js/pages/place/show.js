var Flickity = require('flickity');

var Place = require('../../models/place');
var PlaceMap = require('../../views/place-map');
var DeleteButton = require('../../views/delete-button');
var LikeButton = require('../../views/like-button');


var deleteButton = new DeleteButton();
var likeButton = new LikeButton();

// Gallery
var $gallery = $('.gallery');

var slider = new Flickity($gallery[0], {
    cellAlign: 'left',
    contain: false,
    freeScroll: true,
    imagesLoaded: true,
    pageDots: false,
    percentPosition: false,
});

$gallery.lightGallery({
    selector: '.image',
    download: false,
});

/*
 * To avoid drag image (Flickity) trigger click event that open lightGallery,
 * we use a div raster to cover the image element. The raster div serve as a
 * middleware, decide if click event should be passed to image element and open
 * lightGallery.
 */

var avoidClickTimer = new Date().getTime();
slider.on('dragEnd', function () {
    avoidClickTimer = new Date().getTime();
});

$gallery.find('.raster').click(function () {
    var date = new Date();
    if (date.getTime() - avoidClickTimer > 100) {
        $(this).siblings('.image').click();
    }
});

// Map
var place = new Place({
    latitude: $('.map').data('latitude'),
    longitude: $('.map').data('longitude'),
});
var placeMap = new PlaceMap({
    el: '.map',
    model: place,
});
