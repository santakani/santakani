/**
 * Control designer edit form.
 *
 * View - views/designer/edit.blade.php
 * Style - assets/sass/_edit-layout.scss
 * Script - assets/js/edit/ajax/designer-edit.js
 */

require('../../components/forms/edit-form');

var Image = require('../../models/image');

var ImageChooser = require('../../views/upload/image-chooser');
var ImagePreview = require('../../views/upload/image-preview');
var ImageManager = require('../../views/upload/image-manager');
var ContentEditor = require('../../views/content-editor');
var GalleryEditor = require('../../views/upload/gallery-editor');
var CitySelect = require('../../views/city-select');
var TagSelect = require('../../views/tag-select');
var CoordinateSelect = require('../../views/maps/coordinate-select');


// Image manager
var manager = new ImageManager({
    parentType: 'place',
    parentId: parseInt($('.edit-form').data('id'))
});


// Content editor
$('.content-editor').each(function () {
    new ContentEditor({el: this, imageManager: manager});
});


// Cover chooser
var coverChooser = new ImageChooser({
    el: '#cover-chooser',
    width: 600,
    height: 200,
    inputName: 'image_id',
    manager: manager,
});


// Gallery editor
var galleryEditor = new GalleryEditor({el: '#gallery-editor', imageManager: manager});


// City select
var citySelect = new CitySelect({el: '.city-select'});
// Coordinate select
var coordinateSelect = new CoordinateSelect();

// Update coordinate when changing address
var searchTimeout;

if (!coordinateSelect.latitude || !coordinateSelect.longitude) {
    searchCoordinate();
}

$('#address-input')[0].oninput = searchCoordinateTimer;
$('#city-select')[0].onchange = searchCoordinate;

function searchCoordinateTimer () {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(searchCoordinate, 500);
}

function searchCoordinate() {
    var address = $('#address-input').val().trim();
    var city = $('#city-select option').text().trim();
    if (address.length > 0 && city.length > 0) {
        var query = address + ', ' + city;
        coordinateSelect.search(query);
    }
}

coordinateSelect.address = function () {
    var address = $('#address-input').val().trim();
    var city = $('#city-select option').text().trim();
    return address + ', ' + city;
};

// Tag select
var tagSelect = new TagSelect({el: '.tag-select'});
