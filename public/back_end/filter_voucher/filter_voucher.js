

    // FILTER - STATUS
    $('.btn_filter_voucher_follow_status_apply').click(function(){
        const productId = $('.product_id').val();
        let _token = $('input[name="_token"]').val();
        $.ajax({
            url: '../filter_voucher_follow_status_apply',
            method: 'post',
            data: {
                _token: _token,
                productId: productId,
            },
            success: function (data) {
                $('.content_filter_voucher').html(data);
            }
        });
    });
    $('.btn_filter_voucher_follow_status_unapply').click(function(){
        const productId = $('.product_id').val();
        let _token = $('input[name="_token"]').val();
        $.ajax({
            url: '../filter_voucher_follow_status_unapply',
            method: 'post',
            data: {
                _token: _token,
                productId: productId,
            },
            success: function (data) {
                $('.content_filter_voucher').html(data);
            }
        });
    });

    // FILTER - DATE
    $('#btn_filter_voucher_many_date').click(function(){
        $('.content_filter_voucher_date_single').addClass('dis-none');
        $('.content_filter_voucher_date_many').removeClass('dis-none');
    });
    $('.btn_back_filter_single_date').click(function(){
        $('.content_filter_voucher_date_single').removeClass('dis-none');
        $('.content_filter_voucher_date_many').addClass('dis-none');
    });
    $('#btn_filter_voucher_fol_date').click(function(){
        let productId = $('.product_id').val();
        let date = $('.choose_date_single').val();
        let _token = $('input[name="_token"]').val();

        if(date == ''){
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Vui lòng điền ngày để lọc',
                showConfirmButton: false,
                timer: 1500
            });
        }
        else{
            $.ajax({
                url: '../filter_voucher_follow_date_single',
                method: 'post',
                data: {
                    _token: _token,
                    date: date,
                    productId: productId,
                },
                success: function (data) {
                    $('#Modal_filter_voucher_follow_date_create').modal('hide');
                    $('.content_filter_voucher').html(data);
                }
            });
        }
    });
    $('#btn_filter_voucher_fol_date_many').click(function(){
        let productId = $('.product_id').val();
        let date_start = $('.time_start').val();
        let date_end = $('.time_end').val();
        let _token = $('input[name="_token"]').val();
        if(date_start == '' || date_end == '' || date_start >= date_end){
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
                url: '../filter_voucher_follow_date_many',
                method: 'post',
                data: {
                    _token: _token,
                    date_start: date_start,
                    date_end: date_end,
                    productId: productId,
                },
                success: function (data) {
                    $('#Modal_filter_voucher_follow_date_create').modal('hide');
                    $('.content_filter_voucher').html(data);
                }
            });
        }
    });
