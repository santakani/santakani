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
    this.removeButton.click(function () {
        preview.element.remove();
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
