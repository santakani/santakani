(function () {
    if ($('#profile-setting-page').length === 0) { return; }

    $('#avatar-input').change(function () {
        if (this.files && this.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#avatar-preview').css('background-image', 'url("' + e.target.result + '")');
            }

            reader.readAsDataURL(this.files[0]);
        }
    });
})();
