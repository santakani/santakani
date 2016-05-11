/**
 * Button for uploading new images
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
