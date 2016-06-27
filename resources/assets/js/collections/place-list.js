var Backbone = require('backbone');
var Place = require('../models/place');

module.exports = Backbone.Collection.extend({
    model: Place,
});
