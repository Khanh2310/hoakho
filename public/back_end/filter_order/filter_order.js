
    $('#btn_filter_order_fol_price').click(function(){
        let price_start_order = $('.price_start_order').val();
        let price_end_order = $('.price_end_order').val();
        let _token = $('input[name="_token"]').val();

        if(price_start_order == '' || price_end_order == ''){
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Bạn chưa điền đủ giá cần lọc',
                showConfirmButton: false,
                timer: 1500
            });
        }
        else if(Number(price_start_order) >= Number(price_end_order) || Number(price_start_order) <= 0){
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Vui lòng điền khoảng giá phù hợp',
                showConfirmButton: false,
                timer: 1500
            });
        }
        else{

            $.ajax({
                url: 'filter_order_fol_price',
                method: 'post',
                data: {
                    _token: _token,
                    price_start_order: price_start_order,
                    price_end_order: price_end_order,
                },
                success: function (data) {
                    $('#Modal_filter_order_follow_price').modal('hide');
                    $('.content_filter_order').html(data);
                }
            });
        }

    });

    //filter payment status
    $('.btn_payment').click(function(){
        let status_pay = $(this).attr('data-payment');
        let _token = $('input[name="_token"]').val();
        $.ajax({
            url: 'filter_order_fol_payment_status',
            method: 'post',
            data: {
                _token: _token,
                status_pay: status_pay,
            },
            success: function (data) {
                $('.content_filter_order').html(data);
            }
        });
    })

    // filter payment method
    $('.btn_payment_method').click(function(){
        let payment_method = $(this).attr('data-method-pay');
        let _token = $('input[name="_token"]').val();
        $.ajax({
            url: 'filter_order_fol_payment_method',
            method: 'post',
            data: {
                _token: _token,
                payment_method: payment_method,
            },
            success: function (data) {
                $('.content_filter_order').html(data);
            }
        });
    });

    // filter order date
    $('#btn_filter_order_many_date').click(function(){
        $('.content_filter_order_date_create_single').addClass('dis-none');
        $('.content_filter_order_date_create_many').removeClass('dis-none');
    })
    $('.btn_back_filter_single_date').click(function(){
        $('.content_filter_order_date_create_single').removeClass('dis-none');
        $('.content_filter_order_date_create_many').addClass('dis-none');
    });
    $('#btn_filter_order_fol_date').click(function(){
        let date = $('.choose_date_single').val();
        let _token = $('input[name="_token"]').val();
        if(date == ''){
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Vui lòng nhập ngày cần lọc',
                showConfirmButton: false,
                timer: 1500
            });
        }
        else{
            $.ajax({
                url: 'filter_order_fol_date',
                method: 'post',
                data: {
                    _token: _token,
                    date: date,
                },
                success: function (data) {
                    $('#Modal_filter_order_follow_date').modal('hide');
                    $('.content_filter_order').html(data);
                }
            });
        }
    });
    $('#btn_filter_order_fol_date_many').click(function(){
        let date_start = $('.time_start').val();
        let date_end = $('.time_end').val();
        let _token = $('input[name="_token"]').val();
        if(date_start == '' || date_end == ''){
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Vui lòng nhập ngày cần lọc',
                showConfirmButton: false,
                timer: 1500
            });
        }
        else if(date_start >= date_end){
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Vui lòng nhập khoảng ngày phù hợp',
                showConfirmButton: false,
                timer: 1500
            });
        }
        else{
            $.ajax({
                url: 'filter_order_fol_date_many',
                method: 'post',
                data: {
                    _token: _token,
                    date_start: date_start,
                    date_end: date_end,
                },
                success: function (data) {
                    $('#Modal_filter_order_follow_date').modal('hide');
                    $('.content_filter_order').html(data);
                }
            });
        }
    });

