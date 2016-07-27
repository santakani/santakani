var height = $(window).height() - $('.custom-navbar').height();
$('header').height(height);

$(window).resize(function () {
    var height = $(window).height() - $('.custom-navbar').height();
    $('header').height(height);
});
