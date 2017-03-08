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
var AddressList = require('../../collections/address-list');
var AddressModal = require('../../views/modals/address-modal');

var AddressCard = Backbone.View.extend({

    tagName: 'div',

    className: 'address-card panel panel-default',

    template: _.template($('#address-card-template').html()),

    events: {
        'click .edit-button': 'edit',
        'click .delete-button': 'delete',
    },

    checkbox: false,

    radiobutton: false,

    initialize: function (options) {
        _.extend(this, _.pick(options, 'checkbox', 'radiobutton', 'editor'));

        this.listenTo(this.model, 'destroy', this.remove);
        this.listenTo(this.model, 'change', this.update);
        this.render();
    },

    /**
     * Render DOM from temlplate
     */
    render: function () {
        this.$el.html(this.template(this.model.attributes));
        this.update();
        return this;
    },

    /**
     * Update view from model data
     */
    update: function () {
        this.$('.name').text(this.model.get('name'));
        this.$('.street').text(this.model.get('street'));
        this.$('.postcode').text(this.model.get('postcode'));
        this.$('.city').text(this.model.get('city').name);
        this.$('.country').text(this.model.get('city').country_name);
        this.$('.phone').text(this.model.get('phone'));
        this.$('.email').text(this.model.get('email'));
        return this;
    },

    edit: function () {
        this.editor.edit(this.model);
    },

    /**
     * Remove view and destroy model
     */
    delete: function () {
        this.model.destroy();
    },
});

var AddressManager = Backbone.View.extend({
    el: '#address-manager',

    events: {
        'click .create-button': 'create',
    },

    initialize: function (options) {
        _.extend(this, _.pick(options, 'checkbox', 'radiobutton', 'editor'));

        this.collection = new AddressList();

        this.listenTo(this.collection, 'add', this.add);

        this.collection.add(this.$el.data('collection'));
    },

    create: function () {
        var that = this;
        this.editor.create(function (address) {
            that.collection.add(address);
        });
    },

    add: function (address) {
        var card = new AddressCard({
            model: address,
            editor: this.editor,
        });
        this.$('.address-list').prepend(card.el);
    },
});

var modal = new AddressModal();

new AddressManager({
    editor: modal,
});
