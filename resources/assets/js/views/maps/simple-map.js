/**
 * A simple map that show a single location with a marker and a popup.
 */

var Backbone = require('backbone');
var Leaflet = require('leaflet');

Leaflet.Icon.Default.imagePath = '/img/leaflet';

module.exports = Backbone.View.extend({

    initialize: function (options) {
        this.latitude = this.$el.data('latitude');
        this.longitude = this.$el.data('longitude');
        this.address = this.$el.data('address');

        _.extend(this, _.pick(options, 'latitude', 'longitude', 'address'));

        if (!this.latitude || !this.longitude) {
            this.latitude = 60.164614;
            this.longitude = 24.940338;
            this.zoom = 10;
        } else {
            this.zoom = 14;
            this.marker = Leaflet.marker([this.latitude, this.longitude]);
            if (this.address) {
                this.marker.bindPopup(this.address);
            }
        }

        this.map = Leaflet.map(this.el, {
            scrollWheelZoom: false,
        }).setView([this.latitude, this.longitude], this.zoom);

        this.tile = Leaflet.tileLayer('https://api.mapbox.com/styles/v1/mapbox/streets-v10/tiles/256/{z}/{x}/{y}?access_token=pk.eyJ1Ijoic2FudGFrYW5pIiwiYSI6ImNpcW02em1lZzAwMWpoeW5tdmRiOHh4MTcifQ.sE-MLInkW3KwjlwoaaKuAQ', {
            attribution: '© <a href="https://www.mapbox.com/map-feedback/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> <strong><a href="https://www.mapbox.com/map-feedback/" target="_blank">Improve this map</a></strong>',
            detectRetina: true,
        }).addTo(this.map);

        if (this.marker) {
            this.marker.addTo(this.map);
        }
    },



});
