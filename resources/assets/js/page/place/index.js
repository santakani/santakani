var Backbone = require('backbone');
var ol = require('openlayers');
var d3 = require('d3');

var CitySelect = require('../../view/city-select');

var Place = require('../../model/place');

var PlaceList = require('../../collection/place-list');

var PlaceRow = Backbone.View.extend({

    tagName: 'article',

    className: 'place',

    template: 'hover',

    events: {
        'mouseenter': 'activate',
        'mouseleave': 'deactivate',
    },

    initialize: function () {
        var lon = this.model.get('longitude');
        var lat = this.model.get('latitude');

        this.point = new ol.Feature({
            geometry: new ol.geom.Point( ol.proj.fromLonLat([lon, lat]) )
        });

        this.$('.content').text(this.$('.content').text());

        this.update();

        // Model events
        this.listenTo(this.model, 'change:color', this.updateColor);
        this.listenTo(this.model, 'change:active', this.updateActive);
    },

    update: function () {
        this.updateColor();
        this.updateActive();
    },

    updateColor: function () {
        this.$('.dot').css('background', this.model.get('color'));
        this.updatePoint();
    },

    updateActive: function () {
        if (this.model.get('active')) {
            this.$el.addClass('active');
        } else {
            this.$el.removeClass('active');
        }
        this.updatePoint();
    },

    updatePoint: function () {
        if (this.model.get('active')) {
            var src = '/img/icon/map-dot-active.svg';
        } else {
            var src = '/img/icon/map-dot.svg';
        }
        this.point.setStyle(new ol.style.Style({
            image: new ol.style.Icon( ({
                color: this.model.get('color'),
                src: src
            }))
        }));
    },

    activate: function () {
        this.model.set('active', true);
    },

    deactivate: function () {
        this.model.set('active', false);
    },

});

$(function () {

    if ($('#place-index-page').length === 0) {
        return;
    }

    var c20 = d3.scale.category20().range(); // 20 different colors

    var places = new PlaceList();
    var placeRows = [];
    var points = [];

    $('article.place').each(function (index) {
        var place = new Place({
            latitude: $(this).data('latitude'),
            longitude: $(this).data('longitude'),
            color: c20[index]
        });

        var placeRow = new PlaceRow({
            el: this,
            model: place,
        });

        places.push(place);
        placeRows.push(placeRow);
        points.push(placeRow.point);
    });

    var map = new ol.Map({
        target: 'place-map-draw',
        layers: [
            new ol.layer.Tile({
                source: new ol.source.OSM({layer: 'sat'})
            }),

            new ol.layer.Vector({
                source: new ol.source.Vector({
                    features: points
                })
            })
        ],
        view: new ol.View({
            center: ol.proj.fromLonLat([24.94095, 60.17149]),
            zoom: 12
        })
    });

    map.on('pointermove', function(e) {
        var pixelFeature;

        map.forEachFeatureAtPixel(e.pixel, function(feature, layer) {
            for (var i = 0; i < points.length; i++) {
                if (feature === points[i]) {
                    pixelFeature = feature;
                }
            }
        });


        for (var i = 0; i < placeRows.length; i++) {
            if (pixelFeature === placeRows[i].point) {
                placeRows[i].model.set('active', true);
                placeRows[i].$el.goTo($('#place-list').offset().top);
            } else {
                placeRows[i].model.set('active', false);
            }
        }

    });

    var citySelect = new CitySelect({el: '#city-select'});
});
