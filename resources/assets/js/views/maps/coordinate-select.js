var Backbone = require('backbone');

var Leaflet = require('leaflet');

module.exports = Backbone.View.extend({

    el: '#coordinate-select',

    zoom: 14,

    events: {
        'click .lookup-button': 'lookup',
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

    openFoundAlert: function () {
        this.$('.alert-success').show();
        var that = this;
        setTimeout(function () {
            that.$('.alert-success').fadeOut();
        }, 2000);
    },

    openNotFoundAlert: function () {
        this.$('.alert-warning').show();
        var that = this;
        setTimeout(function () {
            that.$('.alert-warning').fadeOut();
        }, 2000);
    },

    search: function (query, alert) {
        var url = 'https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(query) + '&json_callback=?';
        var that = this;
        $.getJSON(url, function(data) {
            if (data.length > 0) {
                that.setCoordinate(parseFloat(data[0].lat), parseFloat(data[0].lon));
                that.setCenter();
                if (alert) {
                    that.openFoundAlert();
                }
            } else {
                if (alert) {
                    that.openNotFoundAlert();
                }
            }
        });
    },

    lookup: function () {
        this.search(this.address(), true);
    }
});
