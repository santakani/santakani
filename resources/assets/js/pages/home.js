var height = $(window).height() - $('.custom-navbar').height();
$('header').height(height);

var Flickity = require('flickity');

var fkt = new Flickity('#slides', {
    wrapAround: true,
    autoPlay: 10000,
    setGallerySize: false, // Set cell height use CSS rather than JavaScript
});

$('.heading .inner').each(function () {
    var that = this;
    $(this).affix({
        offset: {
            top: function () {
                return $(that).parent().offset().top + 30;
            },
            bottom: function () {
                return $(document).outerHeight() - $(that).parent().offset().top - $(that).parent().outerHeight() + $(that).outerHeight() + 60;
            }
        }
    });
});
