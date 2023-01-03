
    $('.btn_time_discount').click(function(){
        let status_time = $(this).attr('data-time');
        let _token = $('input[name="_token"]').val();
        $.ajax({
            url: 'filter_discount_status_time_discount',
            method: 'post',
            data: {
                _token: _token,
                status_time: status_time,
            },
            success: function (data) {
                $('.content_filter_discount').html(data);
            }
        });
    })

