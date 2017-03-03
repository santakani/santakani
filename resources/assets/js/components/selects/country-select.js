$('.country-select').selectize({

    valueField: 'id', // Attribute in 'data' object for value in <option value="..."></option>

    labelField: 'name', // Attribute in 'data' object for text in <option></option> tags.

    searchField: ['name', 'code'],

    create: false,

    load: function(query, callback) {
        if (!query.length) return callback();

        $.ajax({
            url: '/country',
            type: 'GET',
            dataType: 'json',
            data: {
                search: query
            },
        }).done(function (res) {
            callback(res.data);
        }).fail(function () {
            callback();
        });
    }
});
