$(function () {
    tinymce.init({
        selector: 'textarea.tinymce',
        menubar: false,
        content_css: '/css/app.css',
        setup: function (editor) {
            editor.on('change', function () {
                editor.save();
            });
        }
    });
});
