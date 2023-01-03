
    // filer new product
    $('#filter_new_product').click(function(){
        var _token = $('input[name="_token"]').val();
        var string_new_product = 'Sản Phẩm Mới'
        $.ajax({
            url: 'filter_new_product',
            method: 'post',
            data: {
                _token: _token,
                string_new_product: string_new_product,
            },
            success: function (data) {
                $('.content_filter_product').html(data);
            }
        });
    })

    //filter_product_feature
    $('#filter_product_feature').click(function(){
        var _token = $('input[name="_token"]').val();
        var string_feature_product = 'Sản Phẩm Đặc Trưng'
        $.ajax({
            url: 'filter_product_feature',
            method: 'post',
            data: {
                _token: _token,
                string_feature_product: string_feature_product,
            },
            success: function (data) {
                $('.content_filter_product').html(data);
            }
        });
    });

    /// FILTER PRODUCT-> CATE
    $('#btn_filter_product_many_cate').click(function(){
        $('.content_filter_product_cate_single').addClass('dis-none');
        $('.content_filter_product_many_cate').removeClass('dis-none');
    });
    $('.btn_back_filter_single_cate').click(function(){
        $('.content_filter_product_cate_single').removeClass('dis-none');
        $('.content_filter_product_many_cate').addClass('dis-none');
    });
    $('.cate_id').click(function(){
        $('#btn_filter_product_fol_cate').removeClass('dis-none');
    });
        //single
    $('#btn_filter_product_fol_cate').click(function(){
        let cate_id = $('input[name="cate_id"]:checked').val();
        let _token = $('input[name="_token"]').val();
        $.ajax({
            url: 'filter_product_follow_cate',
            method: 'post',
            data: {
                _token: _token,
                cate_id: cate_id,
            },
            success: function (data) {
                $('.content_filter_product').html(data);
                $('#Modal_filter_product_follow_cate').modal('hide');
            }
        });
    });
        //many cate
    $('#btn_filter_product_fol_cate_many').click(function(){
        var arrCate = [];
        let _token = $('input[name="_token"]').val();
        $.each($("input[name='cate_id[]']:checked"), function(){
            arrCate.push($(this).val());
        });
        if(arrCate.length == 0){
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Bạn chưa chọn danh mục cần lọc',
                showConfirmButton: false,
                timer: 1500
            });
        }
        else{
            $.ajax({
                url: 'filter_product_follow_cate_many',
                method: 'post',
                data: {
                    _token: _token,
                    arrCate: arrCate,
                },
                success: function (data) {
                    $('#Modal_filter_product_follow_cate').modal('hide');
                    $('.content_filter_product').html(data);
                }
            });
        }
    });

    // FILTER PRODUCT-> STORAGE
    $('#btn_filter_product_many_storage').click(function(){
        $('.content_filter_product_storage_single').addClass('dis-none');
        $('.content_filter_product_storage_many').removeClass('dis-none');
    });
    $('.btn_back_filter_single_storage').click(function(){
        $('.content_filter_product_storage_single').removeClass('dis-none');
        $('.content_filter_product_storage_many').addClass('dis-none');
    });
    $('.storage_id').click(function(){
        $('#btn_filter_product_fol_storage').removeClass('dis-none');
    })
    $('#btn_filter_product_fol_storage').click(function(){
        let storage_id = $('input[name="storage_id"]:checked').val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: 'filter_product_follow_storage',
            method: 'post',
            data: {
                _token: _token,
                storage_id: storage_id,
            },
            success: function (data) {
                $('#Modal_filter_product_follow_storage').modal('hide');
                $('.content_filter_product').html(data);
            }
        });
    });
    $('#btn_filter_product_fol_storage_many').click(function(){
        var arrStorage = [];
        let _token = $('input[name="_token"]').val();
        $.each($("input[name='storage_id[]']:checked"), function(){
            arrStorage.push($(this).val());
        });
        if(arrStorage.length == 0){
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Bạn chưa chọn kho cần lọc',
                showConfirmButton: false,
                timer: 1500
            });
        }
        else{
            $.ajax({
                url: 'filter_product_follow_storage_many',
                method: 'post',
                data: {
                    _token: _token,
                    arrStorage: arrStorage,
                },
                success: function (data) {
                    $('#Modal_filter_product_follow_storage').modal('hide');
                    $('.content_filter_product').html(data);
                }
            });
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
    $('.choose_price').click(function(){
        $('#btn_cus_option_price').addClass('dis-none');
        $('#btn_filter_product_fol_price').removeClass('dis-none');
    });
        // change value price
    $('.price_start_cus_option').keyup(function(){
        $('#btn_filter_product_fol_price').removeClass('dis-none');

    });
    $('.price_end_cus_option').keyup(function(){
        $('#btn_filter_product_fol_price').removeClass('dis-none');

    });
    $('.btn_dismiss_modal_filter_price').click(function(){
        $('#btn_cus_option_price').removeClass('dis-none');
        $('input[name="choose_price"]:checked').prop('checked', false);
        $('#btn_filter_product_fol_price').addClass('dis-none');
    });
    $('#btn_filter_product_fol_price').click(function(){
        let radioChoosePrice = $('input[name="choose_price"]:checked').val();
        let _token = $('input[name="_token"]').val();

        if(radioChoosePrice){
            $.ajax({
                url: 'filter_product_follow_price_choose',
                method: 'post',
                data: {
                    _token: _token,
                    radioChoosePrice: radioChoosePrice,
                },
                success: function (data) {
                    $('#btn_filter_product_fol_price').addClass('dis-none');
                    $('#Modal_filter_product_follow_price').modal('hide');
                    $('#btn_cus_option_price').removeClass('dis-none');
                    $('input[name="choose_price"]:checked').prop('checked', false);
                    $('.content_filter_product').html(data);
                }
            });
        }
        else{
            let price_start = Number($('.price_start_cus_option').val());
            let price_end = Number($('.price_end_cus_option').val());
            if(price_start == '' || price_end == ''){
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Chưa có dữ liệu lọc',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
            else if(price_start < 0 || price_end < 0 || price_start >= price_end){
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
                    url: 'filter_product_follow_price_cus_option',
                    method: 'post',
                    data: {
                        _token: _token,
                        price_start: price_start,
                        price_end: price_end,
                    },
                    success: function (data) {
                        $('#btn_filter_product_fol_price').addClass('dis-none');
                        $('#btn_cus_option_price').removeClass('dis-none');
                        $('input[name="choose_price"]:checked').prop('checked', false);
                        $('#Modal_filter_product_follow_price').modal('hide');
                        $('.content_filter_product').html(data);
                    }
                });
            }
        }

    });

    // FILTER PRODUCT -> RATING

    $('.avg_rating_more').click(function(){
        $('#btn_filter_product_fol_rating_many').removeClass('dis-none');
    });
    $('#btn_filter_product_fol_rating_many').click(function(){
        let radioChooseRating = $('input[name="avg_rating_more"]:checked').val();
        let _token = $('input[name="_token"]').val();
        $.ajax({
            url: 'filter_product_follow_rating_choose',
            method: 'post',
            data: {
                _token: _token,
                radioChooseRating: radioChooseRating,
            },
            success: function (data) {
                $('.content_filter_product').html(data);
            }
        });
    });

    // FILTER PRODUCT -> DATE
    $('#btn_filter_product_many_date').click(function(){
        $('.content_filter_product_date_create_single').addClass('dis-none');
        $('.content_filter_product_date_create_many').removeClass('dis-none');
    });
    $('.btn_back_filter_single_date').click(function(){
        $('.content_filter_product_date_create_single').removeClass('dis-none');
        $('.content_filter_product_date_create_many').addClass('dis-none');
    });
    $('#btn_filter_product_fol_date').click(function(){
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
                url: 'filter_product_follow_date_create_single',
                method: 'post',
                data: {
                    _token: _token,
                    date: date,
                },
                success: function (data) {
                    $('#Modal_filter_product_follow_date_create').modal('hide');
                    $('.content_filter_product').html(data);
                }
            });
        }

    });
    $('#btn_filter_product_fol_date_many').click(function(){
        let date_start = $('.time_start').val();
        let date_end = $('.time_end').val();
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
                url: 'filter_product_follow_date_create_many',
                method: 'post',
                data: {
                    _token: _token,
                    date_start: date_start,
                    date_end: date_end,
                },
                success: function (data) {
                    $('#Modal_filter_product_follow_date_create').modal('hide');
                    $('.content_filter_product').html(data);
                }
            });
        }
    });

