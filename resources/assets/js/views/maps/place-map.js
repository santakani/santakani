/**
 * Interactive map for place list.
 */


var Backbone = require('backbone');
var Leaflet = require('leaflet');

var Image = require('../../models/image');
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
        $('#place-list .list').scrollTo(this.el, 300, {offset: -80});
    }

});

var PlaceMarker = Backbone.View.extend({

    initialize: function () {
        var lat = this.model.get('latitude');
        var lng = this.model.get('longitude');

        this.imageModel = new Image(this.model.get('image'));

        if (lat && lng) {
            this.marker = Leaflet.marker([lat, lng]).bindPopup(
                '<a href="' + this.model.url() + '">' +
                '<img src="' + this.imageModel.fileUrl('thumb') +
                '" width="150" height="150"></a>' +
                '<p class="clearfix"><a class="btn btn-xs btn-success pull-right visible-xs-block" href="' + this.model.getGeoUrl() +
                '"><i class="fa fa-lg fa-location-arrow"></i></a>' +
                '<a href="' + this.model.url() + '">' + this.model.get('name') + '</a></p>'
            );
            this.marker.on('click', this.activate, this);
        }

        this.listenTo(this.model, 'change:active', this.closePopup);
    },

    activate: function () {
        this.model.set('active', true);
        this.trigger('activate', this);
    },

    openPopup: function () {
        if (this.marker) {
            this.marker.openPopup();
        }
    },

    closePopup: function () {
        if (this.marker && !this.model.get('active')) {
            this.marker.closePopup();
        }
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

        this.tile = Leaflet.tileLayer('https://api.mapbox.com/styles/v1/mapbox/streets-v10/tiles/256/{z}/{x}/{y}?access_token=pk.eyJ1Ijoic2FudGFrYW5pIiwiYSI6ImNpcW02em1lZzAwMWpoeW5tdmRiOHh4MTcifQ.sE-MLInkW3KwjlwoaaKuAQ', {
            attribution: '© <a href="https://www.mapbox.com/map-feedback/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> <strong><a href="https://www.mapbox.com/map-feedback/" target="_blank">Improve this map</a></strong>',
            detectRetina: true,
        }).addTo(this.map);

        this.collection = new PlaceList();

        var that = this;

        var bounds = [];

        this.$('#place-list .place').each(function () {
            var model = new Place($(this).data('model'));

            var placeRow = new PlaceRow({el: this, model: model});

            var placeMarker = new PlaceMarker({model: model});

            bounds.push([model.get('latitude'), model.get('longitude')]);

            if (placeMarker.marker) {
                placeMarker.marker.addTo(that.map);
            }

            that.collection.add(model);

            that.listenTo(placeRow, 'activate', that.activateRow);

            that.listenTo(placeMarker, 'activate', that.activateMarker);

            placeMarker.listenTo(placeRow, 'activate', placeMarker.openPopup);

            placeRow.listenTo(placeMarker, 'activate', placeRow.scrollTo);
        });

        if (bounds.length > 0) {
            this.map.fitBounds(bounds, {paddingTopLeft: [40, 15], paddingBottomRight: [15, 15]});
        }
    },

    activateRow: function (placeRow) {
        var lat = placeRow.model.get('latitude');
        var lng = placeRow.model.get('longitude');
        if (lat && lng) {
            this.map.setView([lat, lng]);
        }
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
