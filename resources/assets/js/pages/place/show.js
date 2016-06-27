var swal = require('sweetalert');
var Place = require('../../models/place');
var PlaceMap = require('../../views/place-map');

$(function () {

    if($('#place-show-page').length === 0) {
        return;
    }

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

    // Gallery
    $('.gallery').lightGallery({
        selector: 'a:not(.placeholder)',
        thumbWidth: 100,
        thumbContHeight: 120,
    });

    // Map
    var place = new Place({
        latitude: $('.map').data('latitude'),
        longitude: $('.map').data('longitude'),
    });
    var placeMap = new PlaceMap({
        el: '.map',
        model: place,
    });
});
