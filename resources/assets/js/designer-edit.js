// Control designer edit form.

$(function () {
    if (!$('body').hasClass("designer-edit-page")) {
        return;
    }

    // Main image upload

    // When click button, open file dialog
    $("#button-main-image").click(function () {
        $("#input-main-image").click();
    });

    // When selected a file from file dialog, show preview and upload image
    $("#input-main-image").change(function () {
        if (this.files && this.files[0] && this.files[0].name.match(/\.(jpg|jpeg|png|gif)$/)) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#main-image-preview').css('background-image', 'url(' + e.target.result + ')');
            }

            reader.readAsDataURL(this.files[0]);

            // TODO Upload file...
        }
    });

    // Image gallery management

    // Remove image
    $(".image-preview span").click(function () {
        $(this).parent('.image-preview').remove();
    });

    // When click button, open file dialog
    $("#button-upload-image").click(function () {
        $("#input-upload-image").click();
    });

    // When selected a file from file dialog, show preview and upload image
    $("#input-upload-image").change(function () {
        if (this.files && this.files[0] && this.files[0].name.match(/\.(jpg|jpeg|png|gif)$/)) {
            var reader = new FileReader();

            var $imagePreview = $('<div class="image-preview"><span><i class="fa fa-times"></i></span></div>');
            $imagePreview.find('span').click(function () {
                $imagePreview.remove();
            });

            reader.onload = function (e) {
                $imagePreview.css('background-image', 'url(' + e.target.result + ')');
                $imagePreview.appendTo($('#image-gallery'));
            }

            reader.readAsDataURL(this.files[0]);

            // TODO Upload file...
        }
    });
});
