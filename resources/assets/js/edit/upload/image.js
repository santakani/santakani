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
