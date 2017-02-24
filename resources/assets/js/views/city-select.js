var Backbone = require('backbone');

module.exports = Backbone.View.extend({

    tagName: 'select',

    className: 'city-select form-control',

    initialize: function (options) {
        this.$el.selectize({

            valueField: 'id', // Attribute in 'data' object for value in <option value="..."></option>

            labelField: 'full_name', // Attribute in 'data' object for text in <option></option> tags.

            searchField: ['search_index'],

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
                }).done(function (res) {
                    var data = res.data;
                    callback(res.data);
                }).fail(function () {
                    callback();
                });
            },

            render: {
                item: function(data, escape) {
                    var $html = $('<div class="text-nowrap"></div>');
                    $html.text(data.name);
                    $html.attr('data-data', JSON.stringify(data));
                    return $html[0];
                },
                option: function(data, escape) {
                    var $html = $('<div></div>');
                    $html.text(data.full_name);
                    $html.attr('data-data', JSON.stringify(data));
                    return $html[0];
                },
            }
        });

        this.selectize = this.el.selectize;
    },

    selectedValue: function () {
        return this.selectize.items[0];
    },

    selectedData: function () {
        return this.selectize.getItem(this.selectedValue()).data('data');
    },
});
