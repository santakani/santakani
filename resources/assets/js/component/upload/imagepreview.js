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
