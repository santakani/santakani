var sweetalert = require('sweetalert');

$('#user-table .restore-button').click(function () {
    var row = $(this).parents('tr');
    var user = row.data('model');
    sweetalert({
        title: 'Restore User',
        text: "You are going to delete user <strong>" + user.name + "</strong>.",
        type: "info",
        html: true,
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
        allowOutsideClick: true,
    },
    function(){
        $.ajax({
            url: '/user/' + user.id,
            method: 'delete',
            data: {
                restore: true,
                _token: app.token,
            }
        }).done(function () {
            sweetalert({
                title: "User Restored!",
                text: "User <strong>" + user.name + "</strong> has been restored.",
                type: "success",
                html: true,
                allowOutsideClick: true,
            });
            row.remove();
        }).fail(function () {
            sweetalert({
                title: "Failed!",
                text: "Cannot restore user <strong>" + user.name + "</strong>.",
                type: "error",
                html: true,
                confirmButtonColor: "#C1C1C1",
                confirmButtonText: "Close",
                allowOutsideClick: true,
            });
        });
    });
});
