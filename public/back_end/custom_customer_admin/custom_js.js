
$('#find_customer').keyup(function(){
    var value_find = $('#find_customer').val();
    var _token = $('input[name="_token"]').val();
    $.ajax({
        url: 'find_customer',
        method: 'get',
        data: {
            value_find: value_find,
            _token: _token,
        },
        success: function (data) {
            $('.content_find_customer').html(data);
        }
    });
});
