// A custom jQuery plugin to scroll window to specific element.
// Useage: $('#my-div').goTo();

(function($) {
    $.fn.goTo = function() {
        $('html, body').animate({
            scrollTop: $(this).offset().top - 20 + 'px'
        }, 'fast');
        return this; // for chaining...
    }
})(jQuery);

var ImagePreview = function (options) {
    this.init(options).bindEvents();
};

ImagePreview.prototype.init = function (options) {
    if (typeof options.selector === 'string') {
        this.element = $(options.selector);
    } else if (typeof options.element === 'string') {
        this.element = $(options.element);
    } else if (typeof options.element === 'object') {
        this.element = $(options.element);
    } else if (typeof options.template === 'string') {
        this.element = $(options.template).clone();
    } else if (typeof options.template === 'object') {
        this.element = $(options.template).clone();
    }

    this.width = 150;
    this.height = 150;
    if (typeof options.width === 'number' && typeof options.height === 'number') {
        this.width = options.width;
        this.height = options.height;
    }

    this.inputElement = this.element.find('input');
    this.removeButton = this.element.find('.remove');
    this.progressWraper = this.element.find('.progress');
    this.progressBar = this.element.find('.progress-bar');
    this.uploadProgress = 0;
    this.imageId = parseInt(this.inputElement.val());
    this.imageUrl = parseInt(this.inputElement.val());

    return this;
};

ImagePreview.prototype.bindEvents = function () {
    var preview = this;

    // Remove button
    this.removeButton.click(function () {
        preview.element.remove();
    });

    // Responsive size
    this.updateSize();
    $(window).resize(function () {
        preview.updateSize();
    });

    return this;
};

ImagePreview.prototype.progress = function (progress) {
    if (progress === 'hide') {
        this.progressWraper.hide();
    } else if (progress === 'show') {
        this.progressWraper.show();
    } else if (typeof progress === 'number') {
        this.uploadProgress = progress;
        this.progressBar.css('width', progress + '%');
    }

    return this.uploadProgress;
};

ImagePreview.prototype.image = function (id, url) {
    this.imageId = id;
    this.imageUrl = url;
    this.element.css('background-image', 'url("' + url + '")');
    this.inputElement.val(id);

    return {id: this.imageId, url: this.imageUrl};
};

ImagePreview.prototype.size = function (width, height) {
    if (arguments.length === 2) {
        if(width > 0 && height > 0) {
            this.width = width;
            this.height = height;
            this.updateSize();
        }
        return this;
    } else {
        return {width: this.width, height: this.height};
    }
};

ImagePreview.prototype.updateSize = function () {
    this.element.css('width', this.width + 'px');
    this.element.css('height', this.element.width() * this.height / this.width);
};

/**
 * UI for uploading new images and choosing uploaded images
 *
 * View - views/component/input/imageuploader.blade.php
 * Style - assets/sass/_edit-layout.scss
 * Script - assets/js/edit/input/upload/image.js
 */
var ImageUploader = function (options) {

    this.init(options);

    this.bindEvents();

    return this;
};

/**
 * Read options and setup object properties.
 *
 * [Options]
 * selector: string
 * element: string | jQuery | DOM
 * start: function
 *      When file uploading started, call this function.
 * done: function
 *      When file uploading finished or chosen, call this function.
 * fail: function
 *      When error occured, call this function.
 * multiple: boolean
 *      If the modal can choose multiple images, default value is false.
 */
ImageUploader.prototype.init = function (options) {

    if (typeof options === 'object') {
        // 'selector' or 'element' option to bind view.
        if (typeof options.selector === 'string') {
            this.element = $(options.selector);
        } else if (typeof options.element === 'string') {
            this.element = $(options.element);
        } else if (typeof options.element === 'object') {
            this.element = $(options.element);
        }

        // Callback functions
        if (typeof options.start === 'function') {
            this.start = options.start;
        } else {
            this.start = function () {};
        }

        if (typeof options.progress === 'function') {
            this.progress = options.progress;
        } else {
            this.start = function () {};
        }

        if (typeof options.done === 'function') {
            this.done = options.done;
        } else {
            this.done = function () {};
        }

        if (typeof options.fail === 'function') {
            this.fail = options.fail;
        } else {
            this.fail = function () {};
        }

        if (typeof options.multiple === 'boolean') {
            this.multiple = options.multiple;
        } else {
            this.multiple = false;
        }
    } else {
        return null;
    }

    this.uploadButton = this.element.find('button.upload-button');
    this.chooseButton = this.element.find('button.choose-button');
    this.fileInput = this.element.find('input[type="file"]');
    this.chooseModal = this.element.find('div.modal').modal('hide');

    if (this.multiple) {
        this.fileInput.prop('multiple', true);
    }

    return this;
};

/**
 * Initialize user interaction events.
 */
ImageUploader.prototype.bindEvents = function () {

    var uploader = this;

    this.uploadButton.click(function () {
        uploader.fileInput.click();
    });

    var count = 0; // Count all uploading jobs
    // When selected a file from file dialog, show preview and upload image
    this.fileInput.change(function () {
        for (var i = 0; i < this.files.length; i++) {
            var file = this.files[i];

            var data = new FormData();
            data.append('_token', csrfToken);
            data.append('image', file);

            // Upload file one by one...
            // index is the job id of every uploading in queue.
            (function(index){
                uploader.start(index); // Callback function

                $.ajax({
                    method: 'POST',
                    url: '/image',
                    data: data,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();

                        xhr.upload.addEventListener("progress", function(evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = evt.loaded / evt.total;
                                percentComplete = parseInt(percentComplete * 100);
                                uploader.progress(percentComplete, index); // Callback function
                            }
                        }, false);

                        return xhr;
                    }
                }).done(function (response) {
                    var image = response;
                    uploader.done(image, index); // Callback function
                }).fail(function (response) {
                    var error = response;
                    uploader.fail(error, index); // Callback function
                });
            })(count);

            count++;

            // If it is not multiple image uploader, only upload the first one.
            if (!uploader.multiple) {
                break;
            }
        }
    });

    this.chooseButton.click(function () {
        uploader.chooseModal.modal('show');
    });
};

/**
 * Control designer edit form.
 *
 * View - views/designer/edit.blade.php
 * Style - assets/sass/_edit-layout.scss
 * Script - assets/js/edit/ajax/designer-edit.js
 */

$(function () {

    // Page check
    if ($('#designer-edit-page').length === 0) {
        return;
    }

    // Initialize TinyMCE
    tinymce.init({
        selector: 'textarea.tinymce',
        menubar: false,
        content_css: ['/css/app.css', '/css/editor.css'],
        setup: function (editor) {
            editor.on('change', function () {
                editor.save();
            });
        }
    });

    // Initialize ImageUploader for main image
    var imagePreview = new ImagePreview({
        selector: '#image-form-group .image-preview',
        width: 600,
        height: 200
    });

    var imageUploader = new ImageUploader({
        selector: '#image-form-group .image-uploader',
        start: function () {
            imagePreview.progress('show');
        },
        progress: function (percentage) {
            imagePreview.progress(percentage);
        },
        done: function (image) {
            imagePreview.progress('hide');
            imagePreview.image(image.id, image.url.medium);
        },
        fail: function (error) {
            imagePreview.progress('hide');
            console.log(error);
        }
    });

    // Initialize ImageUploader for image gallery
    var oldPreviews = [];
    $('#gallery-form-group .image-gallery .image-preview').each(function () {
        var preview = new ImagePreview({
            element: this
        });
        oldPreviews.push(preview);
    });

    Sortable.create($('.image-gallery')[0], {animation: 300});

    var newPreviews = [];

    var galleryUploader = new ImageUploader({
        selector: '#gallery-form-group .image-uploader',
        multiple: true,
        start: function (index) {
            var preview = new ImagePreview({
                template: $($('#gallery-form-group template').prop('content')).find('.image-preview')
            });
            $('.image-gallery').append(preview.element);
            preview.progress('show');
            newPreviews.push(preview);
        },
        progress: function (percentage, index) {
            newPreviews[index].progress(percentage);
        },
        done: function (image, index) {
            newPreviews[index].progress('hide');
            newPreviews[index].image(image.id, image.url.thumb);
            console.log(index);
        },
        fail: function (error, index) {
            newPreviews[index].progress('hide');
            console.log(error);
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
    $("select#country-select").select2({theme: 'bootstrap'});
    $("select#city-select").select2({theme: 'bootstrap'});

    // Tag select, use Select2
    $("select#tag-select").select2({tags: true, theme: 'bootstrap'});
});

$(function () {

    var $grid = $('#story-list .grid')

    if ($grid.length === 0) {
        return;
    }

    $grid.masonry({
        itemSelector: '.grid-item', // use a separate class for itemSelector, other than .col-
        columnWidth: '.grid-item',
        percentPosition: true
    });

    $grid.find('.story .expand-button').click(function () {
        $(this).parent('.story').toggleClass('expanded');
        $(this).siblings('.content').scrollTop(0);
        $grid.masonry();
    });
});

$(function () {
    $('#picture-carousel').flickity({
        cellAlign: 'left',
        freeScroll: true
    });

    $('#picture-carousel').lightGallery({
        selector: '.picture-thumb',
        exThumbImage: 'data-thumb',
        thumbWidth: 100,
        thumbContHeight: 120
    });
});

var map;
function initMap() {
  map = new google.maps.Map(document.getElementById('place-map-draw'), {
    center: {lat: -34.397, lng: 150.644},
    zoom: 8
  });
}

$(function () {
    $('#place-map-inner').affix({
        offset: {
            top: function () {
                return this.top = $('#kanibar').outerHeight(true) + 20;
            },
            bottom: function () {
                return this.bottom = $('footer').outerHeight(true) + 20;
            }
        }
    });
});

//# sourceMappingURL=app.js.map
