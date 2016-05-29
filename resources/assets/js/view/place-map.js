var ol = require('openlayers');

module.exports = Backbone.View.extend({

    tagName: 'div',

    className: 'place-map',

    initialize: function () {
        this.point = new ol.Feature({
            geometry: new ol.geom.Point(ol.proj.fromLonLat([
                this.model.get('longitude'), this.model.get('latitude')
            ]))
        });
        this.point.setStyle(new ol.style.Style({
            image: new ol.style.Icon( ({
                src: '/img/icon/map-dot-active.svg'
            }))
        }));
        this.map = new ol.Map({
            target: this.el,
            layers: [
                new ol.layer.Tile({
                    source: new ol.source.OSM()
                }),

                new ol.layer.Vector({
                    source: new ol.source.Vector({
                        features: [ this.point ]
                    })
                })
            ],
            view: new ol.View({
                center: ol.proj.fromLonLat([this.model.get('longitude'), this.model.get('latitude')]),
                zoom: 12
            })
        });
    },

});
