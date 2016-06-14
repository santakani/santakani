var swal = require('sweetalert');

var LikeButton = require('../../view/like-button');

$(function () {

    if($('#story-show-page').length === 0) {
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

    var likeButton = new LikeButton({
        el: '#like-button',
    });

    // Action bar ends
});
