$('#avatar-preview').click(function () {
    $('#avatar-input').click();
});

$('#avatar-input').change(function () {
    if (this.files && this.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#avatar-preview').css('background-image', 'url("' + e.target.result + '")');
        }

        reader.readAsDataURL(this.files[0]);
    }
});
