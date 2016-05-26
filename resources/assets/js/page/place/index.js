$(function () {

    if ($('#place-index-page').length === 0) {
        return;
    }

    var ol = require('openlayers');
    var d3 = require('d3');

    var c20 = d3.scale.category20().range(); // 20 different colors

    var points = [];

    $('article.place').each(function (index) {

        var icon = new ol.style.Icon( ({
            color: c20[index],
            src: '/img/icon/map-dot.png'
        }));

        $(this).find('.dot').css('background', c20[index]);

        var $content = $(this).find('.content');
        $content.text($content.text());

        var lon = $(this).data('longitude');
        var lat = $(this).data('latitude');

        var point = new ol.Feature({
            geometry: new ol.geom.Point( ol.proj.fromLonLat([lon, lat]) )
        });

        point.setStyle(new ol.style.Style({
            image: icon
        }));

        points.push(point);
    });

    var map = new ol.Map({
        target: 'place-map-draw',
        layers: [
            new ol.layer.Tile({
                source: new ol.source.OSM({layer: 'sat'})
            }),

            new ol.layer.Vector({
                source: new ol.source.Vector({
                    features: points
                })
            })
        ],
        view: new ol.View({
            center: ol.proj.fromLonLat([24.94095, 60.17149]),
            zoom: 12
        })
    });
});
