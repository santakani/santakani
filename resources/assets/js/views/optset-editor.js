/**
 * Editor view for optset table.
 *
 * Read existing element only. Do NOT render templates.
 */

var Backbone = require('backbone');
var OptionList = require('../collections/option-list');
var Option = require('../models/option');
var OptionEditor = require('../views/option-editor');

module.exports = Backbone.View.extend({

    events: {
        'click .add-button': 'addOption',
    },

    initialize: function (options) {
        _.extend(this, _.pick(options, 'designId', 'type'));

        this.collection = new OptionList();

        this.listenTo(this.collection, 'add', this.addOptionEditor);

        this.collection.add(this.$el.data('collection'));
    },

    /**
     * Create an Option model and add to collection
     */
    addOption: function () {
        var option = new Option({
            design_id: this.designId,
            type: this.type,
            _token: app.token
        });

        console.log(option);

        // Send AJAX and save to database. Then we have option id.
        option.save();

        this.collection.push(option);
    },

    /**
     * Create an OptionEditor view and append it to OptsetEditor
     *
     * @param Option option
     */
    addOptionEditor: function (option) {
        var optionEditor = new OptionEditor({model: option});
        this.$('tbody').append(optionEditor.$el);
    }

});
