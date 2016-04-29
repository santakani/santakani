$(function () {
    $('#picture-carousel').flickity({
        cellAlign: 'left',
        freeScroll: true
    });

    $('#picture-carousel').lightGallery({
        selector: '.picture-thumb',
        exThumbImage: 'data-thumb',
        thumbWidth: 100,
        thumbContHeight: 120
    });
});

 

var map;
function initMap() {
  map = new google.maps.Map(document.getElementById('place-map-draw'), {
    center: {lat: -34.397, lng: 150.644},
    zoom: 8
  });
}

$(function () {
    $('#place-map-inner').affix({
        offset: {
            top: function () {
                return this.top = $('#kanibar').outerHeight(true) + 20;
            },
            bottom: function () {
                return this.bottom = $('footer').outerHeight(true) + 20;
            }
        }
    });
});

$(function () {

    var $grid = $('#story-list .grid')

    if ($grid.length === 0) {
        return;
    }

    $grid.masonry({
        itemSelector: '.grid-item', // use a separate class for itemSelector, other than .col-
        columnWidth: '.grid-item',
        percentPosition: true
    });

    $grid.find('.story .expand-button').click(function () {
        $(this).parent('.story').toggleClass('expanded');
        $(this).siblings('.content').scrollTop(0);
        $grid.masonry();
    });
});

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

/**
 * Control designer edit form.
 *
 * View - views/designer/edit.blade.php
 * Style - assets/sass/_edit-layout.scss
 * Script - assets/js/edit/ajax/designer-edit.js
 */

$(function () {

    if ($('#designer-edit-page').length === 0) {
        return;
    }

    $('button[type="submit"]').click(function (e) {
        e.preventDefault();

        $.ajax({
            method: 'PUT',
            url: $('#designer-edit-form').attr('action'),
            data: $('#designer-edit-form').serializeArray()
        }).done(function () {
            window.location.href = $('#designer-edit-form').attr('action');
        }).fail(function (error) {
            var response = error.responseJSON;
            var $alert = $('#designer-edit-form .alert');
            var message = '';

            for (var id in response) {
                message += '<p>' + response[id] + '</p>';
            }

            $alert.html(message).show().goTo();
        });
    });

    // Country and city select, use Select2.
    $("select#country-select").select2();
    $("select#city-select").select2();

    // Tag select, use Select2
    $("select#tag-select").select2({tags: true});
});

/**
 * Image gallery uploader
 *
 * View - views/component/upload/gallery.blade.php
 * Style - assets/sass/_edit-layout.scss
 * Script - assets/js/edit/upload/gallery.js
 */

$(function () {

    $('.gallery-upload').each(function () {
        var $button = $(this).find('button');
        var $fileInput = $(this).find('input[type="file"]');
        var $gallery = $(this).find('.image-gallery');
        var $imagePreviewTemplate = $($(this).find('template').prop('content')).find('.image-preview');

        // Sortable
        Sortable.create($gallery[0], {animation: 300});

        // Remove image
        $(".image-preview span").click(function () {
            $(this).parent('.image-preview').remove();
        });

        // When click button, open file dialog
        $button.click(function () {
            $fileInput.click();
        });

        // When selected a file from file dialog, show preview and upload image
        $fileInput.change(function () {
            if (this.files && this.files[0] && this.files[0].name.match(/\.(jpg|jpeg|png|gif)$/)) {
                var reader = new FileReader();

                var $imagePreview = $imagePreviewTemplate.clone();
                $imagePreview.find('span').click(function () {
                    $imagePreview.remove();
                });

                reader.onload = function (e) {
                    $imagePreview.css('background-image', 'url(' + e.target.result + ')');
                    $imagePreview.appendTo($gallery);
                }

                reader.readAsDataURL(this.files[0]);

                // TODO Upload file...
            }
        });
    });

});

/**
 * Single image uploader
 *
 * View - views/component/upload/image.blade.php
 * Style - assets/sass/_edit-layout.scss
 * Script - assets/js/edit/upload/image.js
 */

$(function () {

    $('.image-upload').each(function () {
        var $button = $(this).find('button');
        var $fileInput = $(this).find('input[type="file"]');
        var $preview = $(this).find('.image-preview');

        // When click button, open file dialog
        $button.click(function () {
            $fileInput.click();
        });

        // When selected a file from file dialog, show preview and upload image
        $fileInput.change(function () {
            if (this.files && this.files[0] && this.files[0].name.match(/\.(jpg|jpeg|png|gif)$/)) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $preview.css('background-image', 'url(' + e.target.result + ')');
                }

                reader.readAsDataURL(this.files[0]);

                // TODO Upload file...
            }
        });
    });

});

//# sourceMappingURL=app.js.map
