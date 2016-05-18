(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
'use strict';

/**
 * Currently only load own JavaScript, not third-party libraries.
 */

// jQuery plugins
require('./jquery/go-to');

// Utilities
require('./utility/template');

// Pages
require('./page/designer/edit');

},{"./jquery/go-to":3,"./page/designer/edit":5,"./utility/template":6}],2:[function(require,module,exports){
'use strict';

var Image = require('../model/image');

module.exports = Backbone.Collection.extend({

    model: Image,

    url: '/image'

});

},{"../model/image":4}],3:[function(require,module,exports){
'use strict';

// A custom jQuery plugin to scroll window to specific element.
// Useage: $('#my-div').goTo();

(function ($) {
    $.fn.goTo = function () {
        $('html, body').animate({
            scrollTop: $(this).offset().top - 20 + 'px'
        }, 'fast');
        return this; // for chaining...
    };
})(jQuery);

},{}],4:[function(require,module,exports){
'use strict';

/**
 * Class: ImageModel
 *
 * See https://github.com/santakani/santakani.com/wiki/Models#image
 */

module.exports = Backbone.Model.extend({

    defaults: {
        'progress': false, // Upload progress. Uploading: int, 0-100(%); uploaded: false.
        'selectable': false,
        'selected': false
    },

    urlRoot: '/image',

    upload: function upload(options) {
        var that = this;

        var data = new FormData();
        data.append('_token', csrfToken);
        data.append('image', options.image);

        if (typeof options.parentType === 'string' && typeof options.parentId === 'number') {
            data.append('parent_type', options.parentType);
            data.append('parent_id', options.parentId);
        }

        $.ajax({
            method: 'POST',
            url: '/image',
            data: data,
            processData: false,
            contentType: false,
            dataType: 'json',
            xhr: function xhr() {
                var xhr = new window.XMLHttpRequest();

                xhr.upload.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        percentComplete = parseInt(percentComplete * 100);
                        that.set({ progress: percentComplete });
                    }
                }, false);

                return xhr;
            }
        }).done(function (data) {
            that.set(data);
            that.set({ progress: false });
        }).fail(function (error) {
            console.log(error);
        });
    }
});

},{}],5:[function(require,module,exports){
'use strict';

/**
 * Control designer edit form.
 *
 * View - views/designer/edit.blade.php
 * Style - assets/sass/_edit-layout.scss
 * Script - assets/js/edit/ajax/designer-edit.js
 */

var ImagePreview = require('../../view/image-preview');
var Image = require('../../model/image');
var ImageManager = require('../../view/image-manager');

$(function () {

    // Page check
    if ($('#designer-edit-page').length === 0) {
        return;
    }

    // Image manager
    var manager = new ImageManager({
        parentType: 'designer',
        parentId: 1
    });

    // Cover
    var coverImage = new Image({
        id: $('#image-form-group .image-preview').data('id'),
        file_urls: {
            medium: $('#image-form-group .image-preview').data('url')
        }
    });
    var coverPreview = new ImagePreview({
        el: '#image-form-group .image-preview',
        model: coverImage,
        width: 600,
        height: 200,
        imageSize: 'medium'
    });
    $('#image-form-group button').click(function () {
        manager.call({
            multiple: false,
            done: function done(image) {
                coverImage.set(_.omit(image.attributes, 'selectable', 'selected', 'progress'));
                $('#image-form-group input[type="hidden"]').val(image.get('id'));
            }

        });
    });

    // Initialize TinyMCE
    tinymce.init({
        selector: 'textarea.tinymce',
        menubar: false,
        content_css: ['/css/app.css', '/css/editor.css'],
        setup: function setup(editor) {
            editor.on('change', function () {
                editor.save();
            });
        }
    });

    // Submit form
    $('button[type="submit"]').click(function (e) {
        e.preventDefault();

        $.ajax({
            method: 'PUT',
            url: $('#designer-edit-form').attr('action'),
            data: $('#designer-edit-form').serializeArray()
        }).done(function () {
            window.location.href = $('#designer-edit-form').attr('action');
        }).fail(function (error) {
            var response = error.responseJSON;
            var $alert = $('#designer-edit-form .alert');
            var message = '';

            for (var id in response) {
                message += '<p>' + response[id] + '</p>';
            }

            $alert.html(message).show().goTo();
        });
    });

    // Country and city select, use Select2.
    $("select#country-select").select2({ theme: 'bootstrap' });
    $("select#city-select").select2({ theme: 'bootstrap' });

    // Tag select, use Select2
    $("select#tag-select").select2({ tags: true, theme: 'bootstrap' });
});

},{"../../model/image":4,"../../view/image-manager":7,"../../view/image-preview":8}],6:[function(require,module,exports){
'use strict';

// Some template loading and parsing function

// Load template from external HTML files
module.exports.loadFile = function (url, callback) {
    $.get(url, function (templateString) {
        callback(templateString);
    }, 'html');
};

// Load template from DOM, return null if not exists.
module.exports.load = function (element) {
    if ($(element).length) {
        return $(element).html();
    } else {
        return 'Template not found.';
    }
};

},{}],7:[function(require,module,exports){
'use strict';

/**
 * Provide a modal to upload and manage images. Select image to insert to article,
 * set cover image, avatar and so on. Can filter images belong to specifec user,
 * or page.
 */

var ImageList = require('../collection/image-list');
var Image = require('../model/image');
var ImagePreview = require('./image-preview');

module.exports = Backbone.View.extend({

    el: '#image-manager',

    multiple: false, // If can select more than one image

    max: 10, // How many images can be selected at once

    done: function done() {}, // Callback after selection succeed, to be override

    fail: function fail() {}, // Callback after selection fail, to be override

    parentType: null, // Type of images' parent model, such as designer, place

    parentId: null, // Id of images' parent model

    previews: [], // List of sub-view ImagePreview

    my: false, // Whether fetch only my uploads

    events: {
        'click .upload-button': 'openFileBrowser',
        'change .file-input': 'uploadImages',
        'click .cancel-button': 'cancelSelect',
        'click .ok-button': 'finishSelect'
    },

    initialize: function initialize(options) {
        _.extend(this, _.pick(options, 'parentType', 'parentId', 'my', 'fail'));

        this.collection = new ImageList();

        this.listenTo(this.collection, 'add', this.addImage);
        this.listenTo(this.collection, 'all', this.updateOkButton);

        var data = {};
        if (this.my) {
            data['my'] = true;
        } else if (typeof this.parentType === 'string' && typeof this.parentId === 'number') {
            data['parent_type'] = this.parentType;
            data['parent_id'] = this.parentId;
        }

        this.collection.fetch({
            data: data
        });
    },

    render: function render() {
        return this;
    },

    call: function call(options) {
        _.extend(this, _.pick(options, 'multiple', 'max', 'done', 'fail'));
        this.resetSelect();
        this.$el.modal('show');
    },

    resetSelect: function resetSelect() {
        _.each(this.collection.models, function (model) {
            model.set({
                selected: false
            });
        });
        var that = this;
        _.each(this.previews, function (preview) {
            preview.multiple = that.multiple;
        });
    },

    openFileBrowser: function openFileBrowser() {
        this.$('.file-input').click();
    },

    uploadImages: function uploadImages() {
        var files = this.$('.file-input')[0].files;
        for (var i = 0; i < files.length; i++) {
            var image = new Image({
                id: 0,
                selectable: true,
                selected: true
            });
            image.upload({
                image: files[i],
                parentType: this.parentType,
                parentId: this.parentId
            });
            this.collection.add(image);
        }
    },

    /**
     * Fetch uploaded images from server.
     */
    addImage: function addImage(image) {
        image.set({
            selectable: true,
            selected: true
        });
        var preview = new ImagePreview({ model: image });
        this.$('.gallery').prepend(preview.$el);
        this.previews.push(preview);
        this.listenTo(preview, 'select', this.unselectSiblings);
        this.closeAlert();
    },

    unselectSiblings: function unselectSiblings(preview) {
        _.each(_.without(this.previews, preview), function (preview) {
            preview.unselect();
        });
    },

    showAlert: function showAlert(message, type) {
        if (!type || _.contains(['success', 'info', 'warning', 'danger'], type)) {
            type = 'info';
        }
        this.$('.alert').removeClass('alert-info alert-success alert-warning alert-danger').addClass('alert-').text(message).show();
    },

    closeAlert: function closeAlert() {
        this.$('.alert').hide();
    },

    updateOkButton: function updateOkButton() {
        if (this.collection.where({ selected: true }).length > 0) {
            this.$('.ok-button').prop('disabled', false);
        } else {
            this.$('.ok-button').prop('disabled', true);
        }
    },

    cancelSelect: function cancelSelect() {
        this.fail();
    },

    finishSelect: function finishSelect() {
        var selectedImages = this.collection.where({ selected: true });
        if (this.multiple) {
            this.done(selectedImages);
        } else {
            this.done(selectedImages[0]);
        }
        this.$el.modal('hide');
    }

});

},{"../collection/image-list":2,"../model/image":4,"./image-preview":8}],8:[function(require,module,exports){
'use strict';

/**
 * Image thumbnail used for image upload, select and management.
 * Bind to model Image.
 *
 * Class: ImagePreview
 */

var tpl = require('../utility/template');

module.exports = Backbone.View.extend({

    tagName: 'div',

    className: 'image-preview',

    template: _.template(tpl.load('#image-preview-template')),

    width: 150,

    height: 150,

    imageSize: 'thumb',

    removeable: false,

    multiple: false, // true: select like checkbox; false: select like radio button

    events: {
        'click .remove': 'remove',
        'click': 'select'
    },

    initialize: function initialize(options) {
        _.extend(this, _.pick(options, 'width', 'height', 'imageSize', 'removeable', 'multiple'));

        this.render();

        // Responsive size
        this.updateSize();
        $(window).resize(function () {
            preview.updateSize();
        });

        this.listenTo(this.model, 'change', this.update);
    },

    render: function render() {
        this.$el.html(this.template(this.model.attributes));
        this.update();
        return this;
    },

    update: function update() {
        if (this.removeable) {
            this.$('.remove').show();
        } else {
            this.$('.remove').hide();
        }

        this.updateImage();
        this.updateSize();
        this.updateSelect();
        this.updateProgress();
    },

    updateSize: function updateSize() {
        this.$el.css('width', this.width + 'px'); // max-width controlled by CSS.
        this.$el.css('height', this.$el.width() * this.height / this.width);
    },

    select: function select() {
        if (this.multiple) {
            this.model.set({ selected: !this.model.get('selected') });
        } else {
            this.model.set({ selected: true });
            this.trigger('select', this);
        }
    },

    unselect: function unselect() {
        this.model.set({ selected: false });
    },

    updateSelect: function updateSelect() {
        if (!this.model.get('selectable')) {
            return;
        }

        if (this.model.get('selected')) {
            this.$el.addClass('selected');
        } else {
            this.$el.removeClass('selected');
        }
    },

    updateProgress: function updateProgress() {
        var progress = this.model.get('progress');
        if (progress === false) {
            this.$('.progress').hide();
        } else {
            this.$('.progress-bar').css('width', progress + '%');
            this.$('.progress').show();
        }
    },

    updateImage: function updateImage() {
        var url = '';
        if (this.model.get('file_urls')) {
            url = this.model.get('file_urls')[this.imageSize];
        }
        this.$el.css('background-image', 'url(' + url + ')');
    }
});

},{"../utility/template":6}]},{},[1]);

//# sourceMappingURL=app.js.map
