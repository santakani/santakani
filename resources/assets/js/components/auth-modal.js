(function () {

    if ($('#auth-modal').length === 0) { return }

    var $loginPane = $('#login-pane');
    var $registerPane = $('#register-pane');

    $loginPane.find('button[type="submit"]').click(function (e) {
        e.preventDefault();

        $.ajax({
            method: 'post',
            url: $loginPane.find('form').attr('action'),
            data: $loginPane.find('form').serialize(),
            dataType: 'json',
        }).done(function () {
            location.reload();
        }).fail(function (error) {
            var response = error.responseJSON;

            $loginPane.find('.help-block').remove();
            $loginPane.find('.has-error').removeClass('has-error');

            for (var id in response) {
                var $info = $('<span class="help-block">' + response[id][0] + '</span>');
                var $formGroup = $loginPane.find('.' + id + '-form-group' );
                $formGroup.addClass('has-error');
                $formGroup.find('.form-control' ).after($info);
            }
        });
    });

    $registerPane.find('button[type="submit"]').click(function (e) {
        e.preventDefault();

        $.ajax({
            method: 'post',
            url: $registerPane.find('form').attr('action'),
            data: $registerPane.find('form').serialize(),
            dataType: 'json',
        }).done(function () {
            location.reload();
        }).fail(function (error) {
            var response = error.responseJSON;

            $registerPane.find('.help-block').remove();
            $registerPane.find('.has-error').removeClass('has-error');

            for (var id in response) {
                var $info = $('<span class="help-block">' + response[id][0] + '</span>');
                var $formGroup = $registerPane.find('.' + id + '-form-group' );
                $formGroup.addClass('has-error');
                $formGroup.find('.form-control' ).after($info);
            }
        });
    });

})();
