
    $('#find_product').keyup(function(){
        var val_find = $('#find_product').val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: 'find_product',
            method: 'GET',
            data: {
                val_find: val_find,
                _token: _token
            },
            success: function (data) {
                $('.content_find_product').html(data);
            }
        });
    });

