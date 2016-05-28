var CountrySelect = require('../../view/country-select');
var CitySelect = require('../../view/city-select');

$(function () {

    if ($('#place-create-page').length === 0) {
        return;
    }

    var countrySelect = new CountrySelect({el: '.country-select'});
    var citySelect = new CitySelect({el: '.city-select'});

});
