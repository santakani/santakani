$('.tag-filter a').click(function (e) {
    e.preventDefault();
    $('.tag-filter input').val($(this).parents('li').data('id'));
    $(this).parents('form').submit();
});
