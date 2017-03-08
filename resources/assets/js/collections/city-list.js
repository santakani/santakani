/**
 * CityList collection, collection of City model
 *
 *
 */

var Backbone = require('backbone');

var City = require('../models/city');

module.exports = Backbone.Collection.extend({

    model: City,

    url: '/city'

});
