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
