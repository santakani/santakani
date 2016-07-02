var Flickity = require('flickity');

var Place = require('../../models/place');
var PlaceMap = require('../../views/place-map');
var DeleteButton = require('../../views/delete-button');
var LikeButton = require('../../views/like-button');


var deleteButton = new DeleteButton();
var likeButton = new LikeButton();

// Gallery
var $gallery = $('.gallery');

var slider = new Flickity($('.gallery')[0], {
    cellAlign: 'left',
    contain: false,
    freeScroll: true,
    imagesLoaded: true,
    pageDots: false,
    percentPosition: false,
    draggable: false,
});

$gallery.lightGallery({
    selector: '.image',
    download: false,
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
