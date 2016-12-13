resizePageCover();

$(window).resize(resizePageCover);

function resizePageCover() {
    $('.page-cover').outerHeight($(window).outerHeight() - $('.custom-navbar').outerHeight());
    var headerHeight = $(window).outerHeight() - $('.custom-navbar').outerHeight();
    var headerWidth = $('.page-cover').outerWidth();
    var videoOriginalWidth = $('.page-cover .video-background').attr('width');
    var videoOriginalHeight = $('.page-cover .video-background').attr('height');

    if (headerWidth / headerHeight > videoOriginalWidth / videoOriginalHeight) {
        var videoWidth = headerWidth;
        var videoHeight = videoOriginalHeight * headerWidth / videoOriginalWidth;

    } else {
        var videoWidth = videoOriginalWidth * headerHeight / videoOriginalHeight;
        var videoHeight = headerHeight;
    }

    $('.page-cover .video-background').css({
        width: videoWidth,
        height: videoHeight,
        left: (headerWidth - videoWidth) / 2,
        top: (headerHeight - videoHeight) / 2,
    });

}
