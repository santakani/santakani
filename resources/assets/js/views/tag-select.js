var Backbone = require('backbone');
require('selectize');

module.exports = Backbone.View.extend({

    tagName: 'select',

    className: 'tag-select form-control',

    initialize: function (options) {
        this.$el.selectize({

            plugins: ['remove_button'],

            valueField: 'id',

            labelField: 'name',

            searchField: ['search_index'],

            create: false,

            load: function(query, callback) {
                if (!query.length) return callback();
                $.ajax({
                    url: '/tag',
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
            },
        });
    }
});
