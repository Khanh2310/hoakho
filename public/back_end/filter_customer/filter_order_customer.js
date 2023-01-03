// $(document).ready(function(){

    // FILTER ORDER QUANTITY
    $('#btn_cus_option_quantity').click(function(){
        $('.content-filter-price-cus-option').removeClass('dis-none');
        $('.content_filter_choose_price').addClass('dis-none');
    })
    $('.btn_dismiss_modal_filter_price').click(function(){
        $('.content-filter-price-cus-option').addClass('dis-none');
        $('.content_filter_choose_price').removeClass('dis-none');
    });

    // check radio checkbox
    $('.choose_quantity').click(function(){
        $('#btn_cus_option_quantity').addClass('dis-none');
        $('#btn_filter_order_customer_fol_quantity').removeClass('dis-none');
    });
    // change value total order
    $('.quantity_start_cus_option').keyup(function(){
        $('#btn_filter_order_customer_fol_quantity').removeClass('dis-none');
    });
    $('.quantity_end_cus_option').keyup(function(){
        $('#btn_filter_order_customer_fol_quantity').removeClass('dis-none');
    });

    $('.btn_dismiss_modal_filter_price').click(function(){
        $('#btn_cus_option_quantity').removeClass('dis-none');
        $('input[name="choose_quantity"]:checked').prop('checked', false);
        $('#btn_filter_order_customer_fol_quantity').addClass('dis-none');
    });



    $('#btn_filter_order_customer_fol_quantity').click(function(){
        let radioOrderQuantity = $('input[name="choose_quantity"]:checked').val();
        let _token = $('input[name="_token"]').val();

        if(radioOrderQuantity){
            $.ajax({
                url: 'filter_customer_follow_order_quantity_choose',
                method: 'post',
                data: {
                    _token: _token,
                    radioOrderQuantity: radioOrderQuantity,
                },
                success: function (data) {
                    $('#btn_filter_order_customer_fol_quantity').addClass('dis-none');
                    $('#Modal_filter_customer_follow_order_quantity').modal('hide');
                    $('#btn_cus_option_quantity').removeClass('dis-none');
                    $('input[name="choose_quantity"]:checked').prop('checked', false);
                    $('.content_filter_customer').html(data);
                }
            });
        }
        else{
            let quantityStart = Number($('.quantity_start_cus_option').val());
            let quantityEnd = Number($('.quantity_end_cus_option').val());

            if(quantityStart == '' || quantityEnd == ''){
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Chưa có dữ liệu lọc',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
            else if(quantityStart < 0 || quantityEnd < 0 || quantityStart >= quantityEnd){
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Vui lòng điền khoảng số lượng phù hợp',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
            else{
                $.ajax({
                    url: 'filter_customer_follow_order_quantity_cus_option',
                    method: 'post',
                    data: {
                        _token: _token,
                        quantityStart: quantityStart,
                        quantityEnd: quantityEnd,
                    },
                    success: function (data) {
                        $('#btn_filter_order_customer_fol_quantity').addClass('dis-none');
                        $('#Modal_filter_customer_follow_order_quantity').modal('hide');
                        $('#btn_cus_option_quantity').removeClass('dis-none');
                        $('input[name="choose_quantity"]:checked').prop('checked', false);
                        $('.content_filter_customer').html(data);
                    }
                });
            }
        }
    });





    // FILTER PRICE
    $('#btn_cus_option_price').click(function(){
        $('.content-filter-price-cus-option').removeClass('dis-none');
        $('.content_filter_choose_price').addClass('dis-none');
    })
    $('.btn_back_choose_price_filter').click(function(){
        $('.content-filter-price-cus-option').addClass('dis-none');
        $('.content_filter_choose_price').removeClass('dis-none');
    });

    // check radio checkbox
    $('.total_price').click(function(){
        $('#btn_cus_option_price').addClass('dis-none');
        $('#btn_filter_order_customer_fol_price').removeClass('dis-none');
    });
        // change value price
    $('.total_start_price').keyup(function(){
        $('#btn_filter_order_customer_fol_price').removeClass('dis-none');
    });
    $('.total_end_price').keyup(function(){
        $('#btn_filter_order_customer_fol_price').removeClass('dis-none');
    });

    $('.btn_dismiss_modal_filter_price').click(function(){
        $('#btn_cus_option_price').removeClass('dis-none');
        $('input[name="total_price"]:checked').prop('checked', false);
        $('#btn_filter_order_customer_fol_price').addClass('dis-none');
    });



    $('#btn_filter_order_customer_fol_price').click(function(){
        let customerId = $('.customer_id').val();
        let radioTotalPrice = $('input[name="total_price"]:checked').val();
        let _token = $('input[name="_token"]').val();

        if(radioTotalPrice){
            $.ajax({
                url: '../filter_order_customer_follow_price_choose',
                method: 'post',
                data: {
                    _token: _token,
                    radioTotalPrice: radioTotalPrice,
                    customerId: customerId,
                },
                success: function (data) {
                    $('#btn_filter_order_customer_fol_price').addClass('dis-none');
                    $('#Modal_filter_order_customer_follow_price').modal('hide');
                    $('#btn_cus_option_price').removeClass('dis-none');
                    $('input[name="total_price"]:checked').prop('checked', false);
                    $('.content_filter_order_customer').html(data);
                }
            });
        }
        else{
            let totalPriceStart = Number($('.total_start_price').val());
            let totalPriceEnd = Number($('.total_end_price').val());

            if(totalPriceStart == '' || totalPriceEnd == ''){
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Chưa có dữ liệu lọc',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
            else if(totalPriceStart < 0 || totalPriceEnd < 0 || totalPriceStart >= totalPriceEnd){
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
                    url: '../filter_order_customer_follow_price_cus_option',
                    method: 'post',
                    data: {
                        _token: _token,
                        totalPriceStart: totalPriceStart,
                        totalPriceEnd: totalPriceEnd,
                        customerId: customerId,
                    },
                    success: function (data) {
                        $('#btn_filter_order_customer_fol_price').addClass('dis-none');
                        $('#Modal_filter_order_customer_follow_price').modal('hide');
                        $('#btn_cus_option_price').removeClass('dis-none');
                        $('input[name="total_price"]:checked').prop('checked', false);
                        $('.content_filter_order_customer').html(data);
                    }
                });
            }
        }

    });

    // FILTER PRODUCT -> DATE
    $('#btn_filter_order_customer_many_date').click(function(){
        $('.content_filter_order_customer_date_single').addClass('dis-none');
        $('.content_filter_order_customer_date_many').removeClass('dis-none');
    });
    $('.btn_back_filter_single_date').click(function(){
        $('.content_filter_order_customer_date_single').removeClass('dis-none');
        $('.content_filter_order_customer_date_many').addClass('dis-none');
    });
    $('#btn_filter_order_customer_fol_date').click(function(){
        let customerId = $('.customer_id').val();
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
                url: '../filter_order_customer_follow_date_single',
                method: 'post',
                data: {
                    _token: _token,
                    date: date,
                    customerId: customerId,
                },
                success: function (data) {
                    $('#Modal_filter_order_customer_follow_date').modal('hide');
                    $('.content_filter_order_customer').html(data);
                }
            });
        }

    });
    $('#btn_filter_order_customer_fol_date_many').click(function(){
        let customerId = $('.customer_id').val();
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
                url: '../filter_order_customer_follow_date_many',
                method: 'post',
                data: {
                    _token: _token,
                    date_start: date_start,
                    date_end: date_end,
                    customerId: customerId,
                },
                success: function (data) {
                    $('#Modal_filter_order_customer_follow_date').modal('hide');
                    $('.content_filter_order_customer').html(data);
                }
            });
        }
    });
// });
