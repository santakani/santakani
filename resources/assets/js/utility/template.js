// Some template loading and parsing function

// Load template from external HTML files
module.exports.loadFile = function (url, callback) {
    $.get(url, function (templateString) {
        callback(templateString);
    }, 'html');
}

// Load template from DOM, return null if not exists.
module.exports.load = function (element) {
    if ($(element).length) {
        return $(element).html();
    } else {
        return 'Template not found.';
    }
}
