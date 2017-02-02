var CitySelect = require('../../views/city-select');
var PlaceMap = require('../../views/maps/place-map');

// Map
var placeMap = new PlaceMap({el: 'main'});

// Place filter
var citySelect = new CitySelect({el: '#city-select'});

citySelect.$el.change(function () {
    if ($(this).val()) {
        $(this).parents('form').submit();
    }
});

$('input[name="type"]').change(function () {
    $(this).parents('form').submit();
});

$('#place-search').keydown(function (e) {
    if(e.keyCode == 13) {
        $(this).parents('form').submit();
    }
});

$('.tag-filter a').click(function (e) {
    e.preventDefault();
    $('.tag-filter input').val($(this).data('id'));
    $(this).parents('form').submit();
});
