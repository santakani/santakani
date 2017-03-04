/**
 * OptionList, collection of Option model
 *
 *
 */

var Backbone = require('backbone');

var Option = require('../models/option');

module.exports = Backbone.Collection.extend({

    model: Option,

    url: '/option'

});
