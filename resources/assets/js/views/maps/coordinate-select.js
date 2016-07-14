var Backbone = require('backbone');

var Leaflet = require('leaflet');

module.exports = Backbone.View.extend({

    el: '#coordinate-select',

    zoom: 14,

    events: {
        'click .lookup-button': 'lookup',
        'dblclick .locker'     : 'openEditMode',
        'click .manual-button': 'openEditMode',
        'click .close-button' : 'closeEditMode',
    },

    initialize: function () {
        this.$latitudeInput = this.$('input[name="latitude"]');
        this.$longitudeInput = this.$('input[name="longitude"]');

        this.$latitudeText = this.$('.latitude');
        this.$longitudeText = this.$('.longitude');

        this.latitude = parseFloat(this.$latitudeInput.val());
        this.longitude = parseFloat(this.$longitudeInput.val());

        var that = this;

        this.map = Leaflet.map(this.$('.map')[0], {
            scrollWheelZoom: false,
        }).setView([this.latitude, this.longitude], 14);

        this.tile = Leaflet.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(this.map);

        this.map.on('moveend', this.getCenter, this);
    },

    // Move map center by hand
    getCenter: function () {
        var center = this.map.getCenter();
        this.setCoordinate(center.lat, center.lng);
    },

    setCenter: function () {
        this.map.setView([this.latitude, this.longitude], 14);
    },

    setCoordinate: function (latitude, longitude) {
        this.latitude = latitude;
        this.longitude = longitude;
        this.$latitudeInput.val(latitude);
        this.$longitudeInput.val(longitude);
        this.$latitudeText.text(latitude);
        this.$longitudeText.text(longitude);
    },

    openEditMode: function () {
        this.$el.addClass('edit-mode');
    },

    closeEditMode: function () {
        this.$el.removeClass('edit-mode');
    },

    search: function (query) {
        var url = 'https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(query) + '&json_callback=?';
        var that = this;
        $.getJSON(url, function(data) {
            if (data.length > 0) {
                that.setCoordinate(parseFloat(data[0].lat), parseFloat(data[0].lon));
                that.setCenter();
            }
        });
    },

    // This function wil be overrided
    lookup: function () {}
});
