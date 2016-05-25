$(function () {

    if ($('#place-index-page').length === 0) {
        return;
    }

    var ol = require('openlayers');

    var map = new ol.Map({
        target: 'place-map-draw',
        layers: [
            new ol.layer.Tile({
                source: new ol.source.OSM({layer: 'sat'})
            })
        ],
        view: new ol.View({
            center: ol.proj.fromLonLat([24.94095, 60.17149]),
            zoom: 12
        })
    });
});
