var Backbone = require('backbone');
var ol = require('openlayers');
var d3 = require('d3');

var CitySelect = require('../../views/city-select');
var Place = require('../../models/place');
var PlaceList = require('../../collections/place-list');

var map;

// A place item in list + a point in map
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
        var bounce = ol.animation.bounce({
          resolution: map.getView().getResolution(),
          duration: 300,
        });
        var pan = ol.animation.pan({
          source: map.getView().getCenter(),
          duration: 300,
        });
        map.beforeRender(bounce);
        map.beforeRender(pan);
        map.getView().setZoom(14);
        map.getView().setCenter(ol.proj.transform(
            [this.model.get('longitude'), this.model.get('latitude')],
            'EPSG:4326', 'EPSG:3857'));
    },

    deactivate: function () {
        this.model.set('active', false);
    },

});

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

var latitude = $('#place-map').data('latitude');
var longitude = $('#place-map').data('longitude');

map = new ol.Map({
    target: 'place-map',
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
        center: ol.proj.fromLonLat([longitude, latitude]),
        zoom: 14
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
            if (!placeRows[i].model.get('active')) {
                placeRows[i].model.set('active', true);
                $(window).scrollTo(placeRows[i].el, 300, {offset: -100});
            }
        } else {
            if (placeRows[i].model.get('active')) {
                placeRows[i].model.set('active', false);
            }
        }
    }

});

// Place filter

var citySelect = new CitySelect({el: '#city-select'});

citySelect.$el.change(function () {
    if (citySelect.$el.val()) {
        $('#place-filter').submit();
    }
});

$('#place-type-select').selectize({allowEmptyOption: true});
$('#place-type-select').change(function () {
    $('#place-filter').submit();
});

$('.tag-filter button').click(function () {
    $('.tag-filter input').val($(this).data('id'));
    $('#place-filter').submit();
});

$('#place-map .float-icon').click(function () {
    $('#place-map').removeClass('active');
    $('#place-list').addClass('active');
});

$('#place-list .float-icon').click(function () {
    $('#place-list').removeClass('active');
    $('#place-map').addClass('active');
    map.updateSize();
});
