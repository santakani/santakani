var swal = require('sweetalert');

$(function () {

    if($('#designer-show-page').length === 0) {
        return;
    }

    // Header starts
    var $header = $('header');

    updateHeaderHeight();

    $(window).resize(updateHeaderHeight);

    function updateHeaderHeight() {
        var height = $header.width() / 3;
        $header.css('height', height);
    }

    BackgroundCheck.init({
        targets: 'header .target',
        images: 'header',
        threshold: 80,
        minComplexity: 20
    });
    // Header ends

    // Action bar starts

    $('#delete-button').click(function (e) {
        e.preventDefault();

        swal({
            title: "Confirm Delete",
            text: 'Deleted page can be restored in your <a href="/setting">account setting</a> page.',
            type: "warning",
            html: true,
            showCancelButton: true,
            closeOnConfirm: false,
            allowOutsideClick: true,
            showLoaderOnConfirm: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel please!",
        },
        function(){
            $.ajax({
                url: location.pathname,
                method: 'delete',
                data: {
                    _token: csrfToken
                }
            }).done(function () {
                swal("Deleted");
            }).fail(function () {
                swal("Cannot delete this page.");
            });
        });


    });

    // Action bar ends

    // Gallery starts
    $('.gallery').lightGallery({
        thumbWidth: 100,
        thumbContHeight: 120
    });
    // Gallery ends
});
