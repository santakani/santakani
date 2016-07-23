var Backbone = require('backbone');

module.exports = Backbone.View.extend({

    tagName: 'select',

    className: 'country-select',

    initialize: function () {
        this.$el.selectize({

            valueField: 'id', // Attribute in 'data' object for value in <option value="..."></option>

            labelField: 'full_name', // Attribute in 'data' object for text in <option></option> tags.

            searchField: ['search_index'],

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
                }).done(function (res) {
                    callback(res.data);
                }).fail(function () {
                    callback();
                });
            }
        });
    }
});
