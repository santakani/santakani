$(function () {
    $('#picture-carousel').flickity({
        cellAlign: 'left',
        freeScroll: true
    });

    $('#picture-carousel').lightGallery({
        selector: '.picture-thumb'
    });
});
