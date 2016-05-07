$(function () {

    if($('#designer-show-page').length === 0) {
        return;
    }

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

    $('#picture-carousel').flickity({
        cellAlign: 'left',
        freeScroll: true
    });

    $('#picture-carousel').lightGallery({
        selector: '.picture-thumb',
        exThumbImage: 'data-thumb',
        thumbWidth: 100,
        thumbContHeight: 120
    });
});
