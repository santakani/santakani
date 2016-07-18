var sweetalert = require('sweetalert');

$('#user-table .delete-button').click(function () {
    var row = $(this).parents('tr');
    var user = row.data('model');
    sweetalert({
        title: 'Delete User',
        text: "You are going to delete user <strong>" + user.name + "</strong>.",
        type: "warning",
        html: true,
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete!",
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
        allowOutsideClick: true,
    },
    function(){
        $.ajax({
            url: '/user/' + user.id,
            method: 'delete',
            data: {
                _token: app.token,
            }
        }).done(function () {
            sweetalert({
                title: "User Deleted!",
                text: "User <strong>" + user.name + "</strong> has been deleted.",
                type: "success",
                html: true,
                allowOutsideClick: true,
            });
            row.remove();
        }).fail(function () {
            sweetalert({
                title: "Fail!",
                text: "Cannot delete user <strong>" + user.name + "</strong>.",
                type: "error",
                html: true,
                confirmButtonColor: "#C1C1C1",
                confirmButtonText: "Close",
                allowOutsideClick: true,
            });
        });
    });
});
