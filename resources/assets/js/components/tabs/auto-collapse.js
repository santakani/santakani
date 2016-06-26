$(function () {
    $('.nav-tabs').each(function () {
        var $tabs = $(this);
        collapse($tabs);
        $(window).resize(function () {
            collapse($tabs);
        });
    });
});

function collapse($tabs) {

    var $more = $tabs.find('.more');

    if ($more.length === 0) {
        return;
    } else {
        $more.before($more.find('li'));
    }

    $more.hide();

    if ($tabs.outerHeight() < 50) {
        return; // Do not need collapse
    }

    $more.show();

    while($tabs.outerHeight() > 50 && $more.prev().length > 0) {
        $more.find('ul').prepend($more.prev());
    }

    if ($more.find('.active').length === 0) {
        $more.removeClass('active');
    } else {
        $more.addClass('active');
    }

};
