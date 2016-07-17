(function () {

    if ($('body#home-page').length === 0) return; // Check if it is home page

    var Flickity = require('flickity');

    var fkt = new Flickity('#home-carousel', {
        wrapAround: true,
        autoPlay: 10000,
    });

})();
