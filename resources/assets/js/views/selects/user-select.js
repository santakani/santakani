var Backbone = require('backbone');

module.exports = Backbone.View.extend({

    el: '#selected',

    tagName: 'select',

    className: 'user-select form-control',

    initialize: function (options) {
        this.$el.selectize({

            valueField: 'id', // Attribute in 'data' object for value in <option value="..."></option>

            labelField: 'name', // Attribute in 'data' object for text in <option></option> tags.

            searchField: ['name', 'email'],

            create: false,

            placeholder: 'Search user by name or email...',

            load: function(query, callback) {
                if (!query.length) return callback();
                $.ajax({
                    url: '/user',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        search: query
                    },
                }).done(function (res) {
                    var data = res.data;
                    callback(res.data);
                }).fail(function () {
                    callback();
                });
            }
        });
    }
});
