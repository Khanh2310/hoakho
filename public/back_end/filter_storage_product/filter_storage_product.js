
    // FILTER ORDER QUANTITY
    $('#btn_cus_option_quantity').click(function(){
        $('.content-filter-price-cus-option').removeClass('dis-none');
        $('.content_filter_choose_price').addClass('dis-none');
    })
    $('.btn_dismiss_modal_filter_price').click(function(){
        $('.content-filter-price-cus-option').addClass('dis-none');
        $('.content_filter_choose_price').removeClass('dis-none');
    });
    $('.btn_back_choose_price_filter').click(function(){
        $('.content-filter-price-cus-option').addClass('dis-none');
        $('.content_filter_choose_price').removeClass('dis-none');
    });

    // check radio checkbox
    $('.choose_quantity_storage').click(function(){
        $('#btn_cus_option_quantity').addClass('dis-none');
        $('#btn_filter_storage_product_fol_quantity').removeClass('dis-none');
    });
    // change value price
    $('.quantity_start_cus_option').change(function(){
        $('#btn_filter_storage_product_fol_quantity').removeClass('dis-none');
    });
    $('.quantity_end_cus_option').keyup(function(){
        $('#btn_filter_storage_product_fol_quantity').removeClass('dis-none');
    });
    $('.btn_dismiss_modal_filter_price').click(function(){
        $('#btn_cus_option_quantity').removeClass('dis-none');
        $('input[name="choose_quantity_storage"]:checked').prop('checked', false);
        $('#btn_filter_storage_product_fol_quantity').addClass('dis-none');
    });



    $('#btn_filter_storage_product_fol_quantity').click(function(){
        let radioProductQuantity = $('input[name="choose_quantity_storage"]:checked').val();
        let _token = $('input[name="_token"]').val();
        const storageId = $('.storage_id').val();

        if(radioProductQuantity){
            $.ajax({
                url: '../filter_storage_product_quantity_choose',
                method: 'post',
                data: {
                    _token: _token,
                    radioProductQuantity: radioProductQuantity,
                    storageId: storageId,
                },
                success: function (data) {
                    $('#btn_filter_storage_product_fol_quantity').addClass('dis-none');
                    $('#Modal_filter_storage_product_follow_quantity').modal('hide');
                    $('#btn_cus_option_quantity').removeClass('dis-none');
                    $('input[name="choose_quantity_storage"]:checked').prop('checked', false);
                    $('.content_filter_storage_product').html(data);
                }
            });
        }
        else{
            let quantityStart = Number($('.quantity_start_cus_option').val());
            let quantityEnd = Number($('.quantity_end_cus_option').val());
            const storageId = $('.storage_id').val();

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
                    url: '../filter_storage_product_quantity_cus_option',
                    method: 'post',
                    data: {
                        _token: _token,
                        quantityStart: quantityStart,
                        quantityEnd: quantityEnd,
                        storageId: storageId,
                    },
                    success: function (data) {
                        $('#btn_filter_storage_product_fol_quantity').addClass('dis-none');
                        $('#Modal_filter_storage_product_follow_quantity').modal('hide');
                        $('#btn_cus_option_quantity').removeClass('dis-none');
                        $('input[name="choose_quantity_storage"]:checked').prop('checked', false);
                        $('.content_filter_storage_product').html(data);
                    }
                });
            }
        }
    });
