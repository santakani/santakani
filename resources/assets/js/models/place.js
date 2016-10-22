var Backbone = require('backbone');

module.exports = Backbone.Model.extend({
    defaults: {
        active: false,
        selected: false,
    },

    urlRoot: '/place',

    getGeoUrl: function () {
        return 'geo:' + this.get('latitude') + ',' + this.get('longitude');
    },
});
