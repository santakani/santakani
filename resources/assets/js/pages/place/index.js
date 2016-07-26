var CitySelect = require('../../views/city-select');

var PlaceMap = require('../../views/maps/place-map');

// Map
var placeMap = new PlaceMap({el: 'main'});

// Place filter

var citySelect = new CitySelect({el: '#city-select'});

citySelect.$el.change(function () {
    if (citySelect.$el.val()) {
        $('#place-filter').submit();
    }
});

$('#place-type-select').selectize({allowEmptyOption: true});
$('#place-type-select').change(function () {
    $('#place-filter').submit();
});

$('.tag-filter button').click(function () {
    $('.tag-filter input').val($(this).data('id'));
    $('#place-filter').submit();
});

$('#place-filter input[type="search"]').keydown(function (e) {
    if(e.keyCode == 13) {
        $('#place-filter').submit();
    }
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
