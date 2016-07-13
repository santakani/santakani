/**
 * A simple map that show a single location with a marker and a popup.
 */

var Backbone = require('backbone');
var Leaflet = require('leaflet');

Leaflet.Icon.Default.imagePath = '/img/leaflet';

module.exports = Backbone.View.extend({

    initialize: function (options) {
        _.extend(this, _.pick(options, 'latitude', 'longitude', 'address'));

        this.map = Leaflet.map(this.el, {
            scrollWheelZoom: false,
        }).setView([this.latitude, this.longitude], 14);

        this.tile = Leaflet.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(this.map);

        this.marker = Leaflet.marker([this.latitude, this.longitude]).addTo(this.map);
    },



});
