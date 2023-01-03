
    //search voucher
    $('#find_product_voucher').keyup(function(){
        var value_find = $('#find_product_voucher').val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: 'find_product_voucher',
            method: 'get',
            data: {
                value_find: value_find,
                _token: _token
            },
            success: function (data) {
                $('.content_find_product_voucher').html(data);
            }
        });
    });
