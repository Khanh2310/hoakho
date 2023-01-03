
    $('#btn_filter_price_product_history').click(function(){
        let date_start = $('.time_start').val();
        let date_end = $('.time_end').val();
        let product_id = $('.product_id').val();
        let _token = $('input[name="_token"]').val();
        if(date_start == '' || date_end == '' || date_start>=date_end){
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Vui lòng điền ngày phù hợp',
                showConfirmButton: false,
                timer: 1500
            });
        }
        else{
            $.ajax({
                url: '../filter_price_product_history',
                method: 'post',
                data: {
                    _token: _token,
                    date_start: date_start,
                    date_end: date_end,
                    product_id: product_id,
                },
                success: function (data) {
                    $('#Modal_filter_price_product_history').modal('hide');
                    $('.content_filter_price_product_history').html(data);
                }
            });
        }
    })

