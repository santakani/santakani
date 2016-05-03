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
