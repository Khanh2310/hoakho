//search voucher
$('#find_voucher').keyup(function(){
    var value_find = $('#find_voucher').val();
    var _token = $('input[name="_token"]').val();
    var product_id = $('#product_id').val();
    $.ajax({
        url: '../find_voucher',
        method: 'post',
        data: {
            value_find: value_find,
            _token: _token,
            product_id: product_id
        },
        success: function (data) {
            $('.content_find_voucher').html(data);
        }
    });
});