// Control designer edit form.

$(function () {

    if ($('#designer-edit-page').length === 0) {
        return;
    }

    $('button[type="submit"]').click(function (e) {
        e.preventDefault();

        $.ajax({
            method: 'PUT',
            url: $('#designer-edit-form').attr('action'),
            data: $('#designer-edit-form').serializeArray()
        }).done(function () {
            window.location.href = $('#designer-edit-form').attr('action');
        }).fail(function (error) {
            var response = error.responseJSON;
            var $alert = $('#designer-edit-form .alert').show();
            var message = '';

            for (var id in response) {
                message += '<p>' + response[id] + '</p>';
            }

            $alert.html(message);
        });
    });

    // Country and city select, use Select2.
    $("select#country-select").select2();
    $("select#city-select").select2();

    // Tag select, use Select2
    $("select#tag-select").select2({tags: true});
});
