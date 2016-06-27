var $form = $('.edit-form');

// Prevent unexpected form submit caused by "Enter" key press
$form.find('input').keydown(function (e) {
    if(e.keyCode == 13) {
        e.preventDefault();
        return false;
    }
});

// Submit form
$form.find('button[type="submit"]').click(function (e) {
    e.preventDefault();

    var url = $form.attr('action');

    $.ajax({
        method: 'patch',
        url: url,
        data: $form.serialize()
    }).done(function (data) {
        location.href = url;
    }).fail(function (error) {
        renderErrors(error.responseJSON);
    });
});

// Remove all old error messages in the form
function clearErrors() {
    $form.find('.form-group').removeClass('has-error');
    $form.find('.help-block').remove();
}

// Render error messages in the form
function renderErrors(errors) {
    clearErrors();
    for (var name in errors) {
        var $formGroup = $form.find('[name="' + name +'"]').parents('.form-group');
        $formGroup.addClass('has-error');
        var message = '';
        if (typeof errors[name] === 'string') {
            message = errors[name];
        } else if (typeof errors[name] === 'object') {
            message = errors[name][0];
        }
        $formGroup.append('<span class="help-block">' + message + '</span>' );
    }
    $(window).scrollTo('.has-error', 300);
}
