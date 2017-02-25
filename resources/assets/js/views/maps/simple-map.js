/**
 * A simple map that show a single location with a marker and a popup.
 */

var Backbone = require('backbone');
var Leaflet = require('leaflet');

Leaflet.Icon.Default.imagePath = '/img/leaflet';

module.exports = Backbone.View.extend({

    tagName: 'div',

    className: 'simple-map',

    zoom: 14,

    initialize: function (options) {
        _.extend(this, _.pick(options, 'zoom'));

        this.map = Leaflet.map(this.$('.map')[0], {
            scrollWheelZoom: false,
            dragging: false,
            attributionControl: false,
            zoomControl:false
        }).setView([this.model.get('latitude'), this.model.get('longitude')], this.zoom);

        this.tile = Leaflet.tileLayer('https://api.mapbox.com/styles/v1/mapbox/streets-v10/tiles/256/{z}/{x}/{y}?access_token=pk.eyJ1Ijoic2FudGFrYW5pIiwiYSI6ImNpcW02em1lZzAwMWpoeW5tdmRiOHh4MTcifQ.sE-MLInkW3KwjlwoaaKuAQ', {
            detectRetina: true,
        }).addTo(this.map);

        this.marker = Leaflet.marker([this.model.get('latitude'), this.model.get('longitude')]);

        if (this.marker) {
            this.marker.addTo(this.map);
        }
    }

});
