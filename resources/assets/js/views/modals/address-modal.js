/*
 * This file is part of Santakani
 *
 * (c) Guo Yunhe <guoyunhebrave@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

var Backbone = require('backbone');
var Address = require('../../models/address');
var City = require('../../models/city');
var CitySelect = require('../city-select');

/**
 * AddressModal
 *
 * A modal for address creation and editing.
 *
 * Usage:
 *      var modal = new AddressModal({el: '#address-edit-model'});
 *
 *      modal.create(function (address) {
 *          // callback
 *      });
 *
 *      modal.edit(address, function (address) {
 *          // callback
 *      });
 */
module.exports = Backbone.View.extend({

    el: '#address-modal',

    events: {
        'click .save-button': 'save',
        'click .cancel-button': 'cancel',
    },

    initialize: function (options) {
        _.extend(this, _.pick(options, 'option1', 'option2'));

        this.model = new Address();

        this.citySelect = new CitySelect({
            el: this.$('.city-select'),
            labelField: 'full_name',
        });

        this.update();

        this.listenTo(this.model, 'change', this.update);
    },

    update: function () {
        this.$('input[name="name"]').val(this.model.get('name'));
        this.$('input[name="street"]').val(this.model.get('street'));
        this.$('input[name="postcode"]').val(this.model.get('postcode'));
        this.citySelect.select(new City(this.model.get('city')));
        this.$('input[name="phone"]').val(this.model.get('phone'));
        this.$('input[name="email"]').val(this.model.get('email'));
    },

    create: function (callback) {
        this.model = new Address();
        this.update();
        this.callback = callback;
        this.$el.modal('show');
    },

    edit: function (address, callback) {
        this.model = address;
        this.update();
        this.callback = callback;
        this.$el.modal('show');
    },

    save: function () {
        this.model.set('name', this.$('input[name="name"]').val());
        this.model.set('street', this.$('input[name="street"]').val());
        this.model.set('postcode', this.$('input[name="postcode"]').val());
        this.model.set('city_id', this.$('select[name="city_id"]').val());
        this.model.set('phone', this.$('input[name="phone"]').val());
        this.model.set('email', this.$('input[name="email"]').val());
        var that = this;
        this.model.save(null, {
            success: function (model, response, options) {
                if (that.callback) {
                    that.callback(model);
                }
                that.$el.modal('hide');
            },
            error: function (model, response, options) {
                //
            }
        });
    },
});
