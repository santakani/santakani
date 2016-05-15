// Some template loading and parsing function

// Load template from external HTML files
app.util.loadTemplateFile = function (url, callback) {
    $.get(url, function (templateString) {
        callback(templateString);
    }, 'html');
}

// Load template from DOM, return null if not exists.
app.util.loadTemplate = function (element) {
    if ($(element).length) {
        return $(element).html();
    } else {
        return 'Template not found.';
    }
}
