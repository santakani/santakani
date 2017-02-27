var alert = require('sweetalert');

$('.editor-rating-button').click(function (e) {
    e.preventDefault();
    var that = this;

    var url = $(this).attr('href');

    if (!url) {
        url = $(this).data('url');
    }

    alert({
        title: "Set Editor's Rating",
        text: "-100~-1: Unqualified. 0~40: Poor. 40~60: Ordinary. 61~80: Good. 81~100: Excellent",
        type: "input",
        inputType: "number",
        inputValue: $(this).data('rating'),
        showCancelButton: true,
        allowOutsideClick: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
    },
    function(inputValue){
        var data = {
            editor_rating: inputValue,
            _token: app.token
        };
        $.ajax({
            url: url,
            method: 'patch',
            data: data
        }).done(function () {
            alert("Success", "Successfully set editor's rating", "success");
            $(that).data('rating', inputValue);
        }).fail(function () {
            alert("Error", "Cannot set editor's rating.", "error");
        });
    });

});
