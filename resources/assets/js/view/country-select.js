var Backbone = require('backbone');
require('selectize');

module.exports = Backbone.View.extend({

    tagName: 'select',

    className: 'country-select form-control',

    initialize: function (options) {
        this.$el.selectize({

            valueField: 'id',

            labelField: 'name',

            searchField: ['slug', 'name'],

            create: false,

            load: function(query, callback) {
                if (!query.length) return callback();
                $.ajax({
                    url: '/country',
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
            },

            render: {
                option: function(item, escape) {
                    return '<div>' + escape(item.name) + '</div>';
                },
            },
        });
    }
});
