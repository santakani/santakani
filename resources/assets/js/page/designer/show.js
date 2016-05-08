$(function () {

    if($('#designer-show-page').length === 0) {
        return;
    }

    // Header starts
    var $header = $('header');

    updateHeaderHeight();

    $(window).resize(updateHeaderHeight);

    function updateHeaderHeight() {
        var height = $header.width() / 3;
        $header.css('height', height);
    }

    BackgroundCheck.init({
        targets: 'header .target',
        images: 'header',
        threshold: 80,
        minComplexity: 20
    });
    // Header ends

    // Gallery starts
    $('.gallery').lightGallery({
        thumbWidth: 100,
        thumbContHeight: 120
    });
    // Gallery ends
});
