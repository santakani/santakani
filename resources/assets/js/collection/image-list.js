var Image = require('../model/image');

module.exports = Backbone.Collection.extend({

    model: Image,

    url: '/image'

});
