// A custom jQuery plugin to scroll window to specific element.
// Useage: $('#my-div').goTo();


$.fn.goTo = function(offset) {
    if (!offset) {
        offset = 0;
    }
    $('html, body').scrollTop($(this).offset().top - offset);
    return this; // for chaining...
};
