var Backbone = require('backbone');
var Place = require('../model/place');

module.exports = Backbone.Collection.extend({
    model: Place,
});
