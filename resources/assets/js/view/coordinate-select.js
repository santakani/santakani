var Backbone = require('backbone');

var ol = require('openlayers');

module.exports = Backbone.View.extend({

    el: '#coordinate-select',

    initialize: function () {

        this.$latitudeInput = this.$('input[name="latitude"]');
        this.$longitudeInput = this.$('input[name="longitude"]');

        this.$latitudeText = this.$('.latitude');
        this.$longitudeText = this.$('.longitude');

        this.latitude = parseFloat(this.$latitudeInput.val());
        this.longitude = parseFloat(this.$longitudeInput.val());

        var $gridLines = $('<div class="grid-lines"><div></div><div></div></div>');

        this.map = new ol.Map({
            target: this.$('.map')[0],
            layers: [
                new ol.layer.Tile({
                    source: new ol.source.OSM()
                })
            ],
            controls: [
                new ol.control.Control({
                    element: $gridLines[0]
                })
            ],
            view: new ol.View({
                center: ol.proj.fromLonLat([this.longitude, this.latitude]),
                zoom: 12
            })
        });

        var that = this;

        this.map.on('moveend', function (event) {
            var xy = that.map.getView().getCenter();
            var lonlat = ol.proj.transform(xy, 'EPSG:3857', 'EPSG:4326');
            that.updateCoordinate(lonlat[1], lonlat[0]);
        });
    },

    updateCoordinate: function (latitude, longitude) {
        this.latitude = latitude;
        this.longitude = longitude;
        this.$latitudeInput.val(latitude);
        this.$longitudeInput.val(longitude);
        this.$latitudeText.text(latitude);
        this.$longitudeText.text(longitude);
    }

});
