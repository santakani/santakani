// Control designer edit form.

$(function () {
    // Country and city select, use Select2.
    $("select#country-select").select2();
    $("select#city-select").select2();

    // Tag select, use Select2
    $("select#tag-select").select2({tags: true});
});

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

// Control designer edit form.

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

    // Image gallery management
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

//# sourceMappingURL=app.js.map
