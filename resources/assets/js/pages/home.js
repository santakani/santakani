var height = $(window).height() - $('.custom-navbar').height();
$('header').height(height);

$(window).resize(function () {
    var height = $(window).height() - $('.custom-navbar').height();
    $('header').height(height);
});

var Flickity = require('flickity');

var fkt = new Flickity('#home-carousel', {
    wrapAround: true,
    autoPlay: 10000,
    setGallerySize: false, // Set cell height use CSS rather than JavaScript
    //prevNextButtons: false,
});
