$.fn.removeAttrs = function(regex) {
    return this.each(function() {
        for(var i = 0; i < this.attributes.length; i++) {
            var attr = this.attributes.item(i);
            if (attr.specified && regex.test(attr.name)) {
                $(this).removeAttr(attr.name);
            }
        };
    });
};
