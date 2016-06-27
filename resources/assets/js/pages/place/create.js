var CitySelect = require('../../views/city-select');

$(function () {

    if ($('#place-create-page').length === 0) {
        return;
    }

    var citySelect = new CitySelect({el: '.city-select'});

});
