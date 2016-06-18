(function () {

    if ($('#designer-index-page').length === 0) return;

    $('#designer-filter label').click(function () {
        // Wait other JS to check the radio input inside
        setTimeout( function () {
            $('#designer-filter').submit();
        }, 100);
    });

})();
