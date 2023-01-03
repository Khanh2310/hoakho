
    $('.btn_call_quickview_detail').click(function(){
        var product_id = $(this).attr('data-id');
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: 'load_detail_product',
            method: 'POST',
            data: {
                _token: _token,
                product_id:product_id,
            },
            success: function (data) {
                $('.content_mini_detail').html(data);
            }
        });
    });

