(function () {

    var $body = $('body.app-layout');
    var $window = $(window);
    var $footer = $('#site-footer');

    if ($footer.length === 0) {
        return;
    }

    footerPosition();

    $window.resize(footerPosition);

    function footerPosition() {
        var bodyHeight = $footer.hasClass('float') ? ($body.outerHeight() + $footer.outerHeight()) : $body.outerHeight();
        if (bodyHeight < $window.height()) {
            $footer.addClass('float');
        } else {
            $footer.removeClass('float');
        }
    }
})();
