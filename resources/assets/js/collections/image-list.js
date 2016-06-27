var Backbone = require('backbone');

var Image = require('../models/image');

module.exports = Backbone.Collection.extend({

    model: Image,

    url: '/image'

});
