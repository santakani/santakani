/**
 * Option model
 *
 */

var Backbone = require('backbone');

module.exports = Backbone.Model.extend({
    defaults: {
        value: null,
        price_add: 0,
        available: 1,
        sort_order: 0,
        translations: [
            {
                locale: 'en',
                name: 'New option'
            }
        ]
    },

    urlRoot: '/option',

    destroy: function () {
        return Backbone.Model.prototype.destroy.call(this, {
            data: {
                _token: app.token,
            },
            processData: true,
        });
    },

    /**
     * Get name (English) of option
     */
    getName: function (locale) {

        if (!locale) {
            locale = 'en';
        }

        if (!this.has('translations')) {
            return '';
        }

        var translations = this.get('translations');

        if (translations && translations.length) {
            var i;
            for (i = 0; i < translations.length; i++) {
                if (translations[i].locale && translations[i].locale === locale) {
                    return translations[i].name;
                }
            }
        }

        return '';
    },
});
