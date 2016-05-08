/**
 * Class: Image
 *
 * Namespace: app.model
 *
 * Model that represents an image from server.
 */

(function () {
    var mImage;
    app.model.Image = mImage = function (options) {
        this.init(options);

        return this;
    };

    mImage.prototype.init = function (options) {
        var defaults = {};

        /* merge defaults and options, without modifying defaults */
        $.extend(this, defaults, options);
    };

    mImage.prototype.fetch = function () {
        if (!this.id) {
            return this;
        }

        // TODO fetch image data from server.

        return this;
    };
})();
