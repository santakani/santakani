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

$('#place-type-select').change(function () {
    $(this).parents('form').submit();
});

$('#place-search').keydown(function (e) {
    if(e.keyCode == 13) {
        $(this).parents('form').submit();
    }
});

$('.tag-filter a').click(function (e) {
    e.preventDefault();
    $('.tag-filter input').val($(this).parents('li').data('id'));
    $(this).parents('form').submit();
});

// Float icons
$('#place-map .float-icon').click(function () {
    $('#place-map').removeClass('active');
    $('#place-list').addClass('active');
});

$('#place-list .float-icon').click(function () {
    $('#place-list').removeClass('active');
    $('#place-map').addClass('active');
});
