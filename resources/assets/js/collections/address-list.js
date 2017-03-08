/**
 * AddressList collection, collection of Address model
 *
 *
 */

var Backbone = require('backbone');

var Address = require('../models/address');

module.exports = Backbone.Collection.extend({

    model: Address,

    url: '/address'

});
