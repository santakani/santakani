var CitySelect = require('../../view/city-select');

$(function () {

    if ($('#designer-create-page').length === 0) {
        return;
    }

    var citySelect = new CitySelect({el: '.city-select'});

});
