var LikeButton = require('../../views/like-button');
var DeleteButton = require('../../views/delete-button');

new LikeButton();
new DeleteButton();

$('#gallery').lightSlider({
    gallery:true,
    item:1,
    loop:true,
    thumbItem:9,
    slideMargin:0,
    enableDrag: false,
    currentPagerPosition:'left',
    onSliderLoad: function(el) {
        el.lightGallery({
            selector: '#gallery .lslide'
        });
    }
});
