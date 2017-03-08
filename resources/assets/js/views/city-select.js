var Backbone = require('backbone');

module.exports = Backbone.View.extend({

    tagName: 'select',

    className: 'city-select form-control',

    valueField: 'id',

    labelField: 'name',

    initialize: function (options) {
        _.extend(this, _.pick(options, 'valueField', 'labelField', 'my', 'fail'));

        this.$el.selectize({

            valueField: this.valueField, // model field for <option value="..."></option>

            labelField: this.labelField, // model field for <option>...</option>

            // model fields for searching (locally)
            searchField: ['name', 'english_name', 'country_name', 'english_country_name'],

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
                /**
                 * Render selected in input box
                 */
                item: function(data, escape) {
                    var $html = $('<div class="text-nowrap"></div>');
                    $html.text(data.name);
                    $html.attr('data-data', JSON.stringify(data));
                    return $html[0];
                },

                /**
                 * Render options in dropdown list
                 */
                option: function(data, escape) {
                    var $html = $('<div></div>');
                    $html.text(data.full_name);
                    $html.attr('data-data', JSON.stringify(data));
                    return $html[0];
                },
            }
        });
    },

    /**
     * Get selected city id. NOTE this select only support one chosen option.
     *
     * @return int
     */
    selectedValue: function () {
        return this.el.selectize.items[0];
    },

    /**
     * Get selected city model. NOTE this select only support one chosen option.
     *
     * @return object
     */
    selectedData: function () {
        return this.el.selectize.getItem(this.selectedValue()).data('data');
    },

    /**
     * Select a city.
     *
     * @param City city Model to be selected
     */
    select: function (city) {
        this.el.selectize.clear();
        this.el.selectize.addOption(city.attributes);
        this.el.selectize.addItem(city.id);
    }
});
