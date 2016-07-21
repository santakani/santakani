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

        this.tile = Leaflet.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(this.map);

        if (this.marker) {
            this.marker.addTo(this.map);
        }
    },



});
