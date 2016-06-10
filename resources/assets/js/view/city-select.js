var Backbone = require('backbone');
require('selectize');

module.exports = Backbone.View.extend({

    tagName: 'select',

    className: 'city-select form-control',

    initialize: function (options) {
        var that = this;
        this.$el.selectize({

            valueField: 'id', // Attribute in 'data' object for value in <option value="..."></option>

            labelField: 'full_name', // Attribute in 'data' object for text in <option></option> tags.

            searchField: ['slug', 'name'],

            create: false,

            load: function(query, callback) {
                if (!query.length) return callback();
                $.ajax({
                    url: '/city',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        search: query
                    },
                    error: function() {
                        callback();
                    },
                    success: function(res) {
                        callback(res.data);
                    }
                });
            }
        });
    }
});
