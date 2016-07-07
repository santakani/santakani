var $body = $('body.app-layout');
var $window = $(window);
var $footer = $('#app-footer');

footerPosition();

$window.resize(footerPosition);

setInterval(footerPosition, 50);

function footerPosition() {
    var bodyHeight = $footer.hasClass('float') ? ($body.outerHeight() + $footer.outerHeight()) : $body.outerHeight();
    if (bodyHeight < $window.height()) {
        $footer.addClass('float');
    } else {
        $footer.removeClass('float');
    }
}
