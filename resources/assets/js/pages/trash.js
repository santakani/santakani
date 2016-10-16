var sweetAlert = require('sweetalert');

$('.delete-button').click(function () {
    var pageElement = $(this).parents('tr');
    var url = $(this).parents('tr').data('url');
    $.ajax({
        url: url,
        method: 'delete',
        data: {
            action: 'force_delete',
            _token: app.token
        },

    }).done(function () {
        pageElement.remove();
    }).fail(function () {
        sweetAlert("Delete Failed", "Please refresh page and try again.", "error");
    });
});

$('.restore-button').click(function () {
    var pageElement = $(this).parents('tr');
    var url = $(this).parents('tr').data('url');
    $.ajax({
        url: url,
        method: 'delete',
        data: {
            action: 'restore',
           _token: app.token
        },

    }).done(function () {
        pageElement.remove();
    }).fail(function () {
        sweetAlert("Restore Failed", "Please refresh page and try again.", "error");
    });
});
