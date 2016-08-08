var Backbone = require('backbone');

module.exports = Backbone.View.extend({
    initialize: function () {
        this.$el.lightSlider({
            item: 8,
            slideMove: 4,
            loop: false,
            enableDrag: false,
            pager: false,
            responsive : [
                {
                    breakpoint: 1800,
                    settings: {
                        item: 7,
                        slideMove: 3,
                    }
                },
                {
                    breakpoint: 1500,
                    settings: {
                        item: 6,
                        slideMove: 3,
                    }
                },
                {
                    breakpoint: 1200,
                    settings: {
                        item: 5,
                        slideMove: 2,
                    }
                },
                {
                    breakpoint: 992,
                    settings: {
                        item: 4,
                        slideMove: 2,
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        item: 3,
                        slideMove: 1,
                    }
                },
                {
                    breakpoint:480,
                    settings: {
                        item: 2,
                        slideMove: 1
                    }
                }
            ],
            onSliderLoad: function(el) {
                el.lightGallery({
                    selector: '.lslide'
                });
            },
        });
    },
});
