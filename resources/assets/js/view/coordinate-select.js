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
                center: [0, 0],
                zoom: 13
            })
        });

        if (this.latitude && this.longitude) {
            this.updateCenter();
        }

        var that = this;

        this.map.on('moveend', function (event) {
            if (!that.updatingCenter) {
                var xy = that.map.getView().getCenter();
                var lonlat = ol.proj.transform(xy, 'EPSG:3857', 'EPSG:4326');
                that.setCoordinate(lonlat[1], lonlat[0]);
            }
        });
    },

    setCoordinate: function (latitude, longitude) {
        this.latitude = latitude;
        this.longitude = longitude;
        this.$latitudeInput.val(latitude);
        this.$longitudeInput.val(longitude);
        this.$latitudeText.text(latitude);
        this.$longitudeText.text(longitude);
    },

    updateCenter: function () {
        this.updatingCenter = true;
        this.map.getView().setCenter(ol.proj.transform([this.longitude, this.latitude], 'EPSG:4326', 'EPSG:3857'));
        this.map.getView().setZoom(13);
        this.updatingCenter = false;
    },

    search: function (query) {
        var url = 'https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(query) + '&json_callback=?';
        var that = this;
        $.getJSON(url, function(data) {
            if (data.length > 0) {
                that.setCoordinate(parseFloat(data[0].lat), parseFloat(data[0].lon));
                that.updateCenter();
            }
        });
    }

});
