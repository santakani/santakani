$('.tag-filter button').click(function () {
    $('.tag-filter input').val($(this).data('id'));
    $('#story-filter').submit();
});
