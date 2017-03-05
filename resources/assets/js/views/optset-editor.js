/**
 * Editor view for optset table.
 *
 * Read existing element only. Do NOT render templates.
 */

var Backbone = require('backbone');
var Sortable = require('sortablejs');
var OptionList = require('../collections/option-list');
var Option = require('../models/option');
var OptionEditor = require('../views/option-editor');

module.exports = Backbone.View.extend({

    hasColor: false,
    hasImage: false,

    events: {
        'click .add-button': 'addOption',
    },

    initialize: function (options) {
        _.extend(this, _.pick(options, 'designId', 'type', 'imageManager', 'hasColor', 'hasImage'));

        this.collection = new OptionList();
        this.collection.comparator = 'sort_order';

        // Array of OptionEditor views
        this.views = [];

        this.listenTo(this.collection, 'add', this.add);

        this.collection.add(this.$el.data('collection'));

        var that = this;

        // Drag & sort option lists
        this.sortable = Sortable.create(this.$('tbody')[0], {
            handle: '.drag-handle',
            dataId: 'data-id',
            onEnd: this.index.bind(this),
        });
    },

    /**
     * Create an Option model and add to collection
     */
    addOption: function () {
        var option = new Option({
            design_id: this.designId,
            type: this.type,
        });

        if (this.collection.length) {
            option.set('sort_order', this.collection.last().get('sort_order') + 1);
        }

        // Send AJAX and save to database. Then we have option id.
        option.save();

        this.collection.push(option);
    },

    /**
     * Create an OptionEditor view and append it to OptsetEditor
     *
     * @param Option option
     */
    add: function (option) {
        var optionEditor = new OptionEditor({
            model: option,
            imageManager: this.imageManager,
            hasColor: this.hasColor,
            hasImage: this.hasImage,
        });
        this.$('tbody').append(optionEditor.$el);
        this.views.push(optionEditor);
    },

    /**
     * Call child views to reindex and save order in their model
     */
    index: function () {
        _.each(this.views, function (view, index, views) {
            view.index();
        });
    },

});
