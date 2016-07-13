/**
 * Interactive map for place list.
 */


var Backbone = require('backbone');
var Leaflet = require('leaflet');

var Place = require('../../models/place');
var PlaceList = require('../../collections/place-list');

Leaflet.Icon.Default.imagePath = '/img/leaflet';

var PlaceRow = Backbone.View.extend({

    events: {
        'mouseenter': 'activate',
        'mouseleave': 'deactivate',
    },

    initialize: function () {
        this.listenTo(this.model, 'change:active', this.updateActive);
    },

    updateActive: function () {
        if (this.model.get('active')) {
            this.$el.addClass('active');
        } else {
            this.$el.removeClass('active');
        }
    },

    activate: function () {
        this.model.set('active', true);
        this.trigger('activate', this);
    },

    deactivate: function () {
        this.model.set('active', false);
    },

    scrollTo: function () {
        $(window).scrollTo(this.el, 300, {offset: -200});
    }

});

var PlaceMarker = Backbone.View.extend({

    initialize: function () {
        this.marker = Leaflet.marker([this.model.get('latitude'), this.model.get('longitude')])
                      .bindPopup(this.model.get('name'));

        var that = this;

        this.marker.on('click', function () {
            that.activate();
        });
    },

    activate: function () {
        this.model.set('active', true);
        this.trigger('activate', this);
    },

    openPopup: function () {
        this.marker.openPopup();
    }

});

module.exports = Backbone.View.extend({

    initialize: function (options) {
        _.extend(this, _.pick(options, 'latitude', 'longitude'));

        if (!this.latitude || !this.longitude) {
            this.latitude = this.$('#place-map').data('latitude');
            this.longitude = this.$('#place-map').data('longitude');
        }

        this.map = Leaflet.map('place-map').setView([this.latitude, this.longitude], 13);

        this.tile = Leaflet.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(this.map);

        this.collection = new PlaceList();

        var that = this;

        this.$('.place').each(function () {
            var model = new Place($(this).data('model'));

            var placeRow = new PlaceRow({el: this, model: model});

            placeRow.map = that.map;

            var placeMarker = new PlaceMarker({model: model});

            placeMarker.marker.addTo(that.map);

            that.collection.add(model);

            that.listenTo(placeRow, 'activate', that.activateRow);

            that.listenTo(placeMarker, 'activate', that.activateMarker);

            placeMarker.listenTo(placeRow, 'activate', placeMarker.openPopup);

            placeRow.listenTo(placeMarker, 'activate', placeRow.scrollTo);
        });
    },

    activateRow: function (placeRow) {
        this.map.setView([placeRow.model.get('latitude'), placeRow.model.get('longitude')]);
        this.collection.each(function (m) {
            if (m != placeRow.model) {
                m.set('active', false);
            }
        });
    },

    activateMarker: function (placeMarker) {
        this.collection.each(function (m) {
            if (m != placeMarker.model) {
                m.set('active', false);
            }
        });
    },
});
