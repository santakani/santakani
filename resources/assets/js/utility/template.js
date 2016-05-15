// Some template loading and parsing function

// Load template from external HTML files
var loadTemplateFile = app.util.loadTemplateFile = function (url, callback) {
    $.get(url, function (templateString) {
        callback(templateString);
    }, 'html');
}

// Load template from DOM, return null if not exists.
var loadTemplate = app.util.loadTemplate = function (element) {
    return $(element).html();
}
