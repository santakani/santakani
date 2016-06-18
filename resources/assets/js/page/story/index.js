(function () {

    if ($('#story-index-page').length === 0) return;

    $('#story-filter label').click(function () {
        // Wait other JS to check the radio input inside
        setTimeout( function () {
            $('#story-filter').submit();
        }, 100);
    });

})();
