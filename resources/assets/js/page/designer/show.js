$(function () {
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
