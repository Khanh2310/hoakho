
    var keyword_search = $('.keyword_search').val();
    var _token = $('input[name="_token"]').val();
    $('.choose_cate_search').click(function (){
        //
        $('.val_price_filter_start').val('');
        $('.val_price_filter_end').val('');
        $('.check_cus_price').removeClass('selected');
        //
        var cate_id = $(this).attr('data-id');
            $.ajax({
                url: 'ajax_search_cate_and_keyword',
                method: 'POST',
                data: {
                    _token: _token,
                    keyword_search: keyword_search,
                    cate_id: cate_id,
                },
                success: function (data) {
                    $('.content_list_product_search').html(data);
                    //alert(data);
                }
            });
    });

    // filter rating
    $('.choose_rating_search').click(function(){
        //
        $('.check_cus_price').removeClass('selected');
        $('.check_cus_cate').removeClass('selected');
        $('.val_price_filter_start').val('');
        $('.val_price_filter_end').val('');
        //
        var rating = $(this).attr('data-id');
        $.ajax({
            url: 'ajax_search_rating_and_keyword',
            method: 'POST',
            data: {
                _token: _token,
                keyword_search: keyword_search,
                rating: rating,
            },
            success: function (data) {
                $('.content_list_product_search').html(data);
                //alert(data);
            }
        });
    });

    // filter price
    $('.btn_filter_price').click(function (){
        //
        $('.check_cus_price').removeClass('selected');
        $('.check_cus_cate').removeClass('selected');
        //
        var price_start = Number($('.val_price_filter_start').val());
        var price_end = Number($('.val_price_filter_end').val());

        if(price_start >= price_end || price_start < 0){
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Vui lòng điền khoảng giá phù hợp',
                showConfirmButton: false,
                timer: 2000
            });
        }
        else{
            $.ajax({
                url: 'ajax_search_price_and_keyword',
                method: 'POST',
                data: {
                    _token: _token,
                    keyword_search: keyword_search,
                    price_start: price_start,
                    price_end: price_end,
                },
                success: function (data) {
                    $('.content_list_product_search').html(data);
                }
            });
        }
    });

    $('.check_filter_price').click(function(){
        //
        $('.val_price_filter_start').val('');
        $('.val_price_filter_end').val('');
        $('.check_cus_cate').removeClass('selected');
        //
        var check_price_id = $(this).attr('data-id');
        if(check_price_id == 1){
            var price_start = 1000;
            var price_end = 50000;
            $.ajax({
                url: 'ajax_search_price_and_keyword',
                method: 'POST',
                data: {
                    _token: _token,
                    keyword_search: keyword_search,
                    price_start: price_start,
                    price_end: price_end,
                },
                success: function (data) {
                    $('.content_list_product_search').html(data);
                }
            });
        }
        else if(check_price_id == 2){
            var price_start = 50000;
            var price_end = 100000;
            $.ajax({
                url: 'ajax_search_price_and_keyword',
                method: 'POST',
                data: {
                    _token: _token,
                    keyword_search: keyword_search,
                    price_start: price_start,
                    price_end: price_end,
                },
                success: function (data) {
                    $('.content_list_product_search').html(data);
                }
            });
        }
        else if(check_price_id == 3){
            var price_start = 100000;
            var price_end = 500000;
            $.ajax({
                url: 'ajax_search_price_and_keyword',
                method: 'POST',
                data: {
                    _token: _token,
                    keyword_search: keyword_search,
                    price_start: price_start,
                    price_end: price_end,
                },
                success: function (data) {
                    $('.content_list_product_search').html(data);
                }
            });
        }
        else if(check_price_id == 4){
            var price_start = 500000;
            var price_end = 1000000;
            $.ajax({
                url: 'ajax_search_price_and_keyword',
                method: 'POST',
                data: {
                    _token: _token,
                    keyword_search: keyword_search,
                    price_start: price_start,
                    price_end: price_end,
                },
                success: function (data) {
                    $('.content_list_product_search').html(data);
                }
            });
        }
        else{
            var price_start = 1000000;
            var price_end = 1000000000;
            $.ajax({
                url: 'ajax_search_price_and_keyword',
                method: 'POST',
                data: {
                    _token: _token,
                    keyword_search: keyword_search,
                    price_start: price_start,
                    price_end: price_end,
                },
                success: function (data) {
                    $('.content_list_product_search').html(data);
                }
            });
        }
    });

    // sort price
    $('.sort_price_fiter').change(function(){
        var val_sort_price = $('.sort_price_fiter option:selected').val();
        var type_filter = $('.type_filter').val();
        var level_filter = $('.level_filter').val();
        var level_filter_price_start = $('.level_filter_price_start').val();
        var level_filter_price_end = $('.level_filter_price_end').val();
        // set default another select

        //$('.sort_rating_fiter').selectmenu("refresh", true);
        $(".sort_rating_fiter option:selected").prop("selected", false);
        //

        $.ajax({
            url: 'ajax_sort_price_and_keyword',
            method: 'POST',
            data: {
                _token: _token,
                keyword_search: keyword_search,
                val_sort_price: val_sort_price,
                type_filter: type_filter,
                level_filter: level_filter,
                level_filter_price_start: level_filter_price_start,
                level_filter_price_end: level_filter_price_end,
            },
            success: function (data) {
                $('.content_list_product_search').html(data);
            }
        });
        //alert(type_filter);
    });
    // sort rating
    $('.sort_rating_fiter').change(function(){
        var sort_rating_fiter = $('.sort_rating_fiter option:selected').val();
        var type_filter = $('.type_filter').val();
        var level_filter = $('.level_filter').val();
        var level_filter_price_start = $('.level_filter_price_start').val();
        var level_filter_price_end = $('.level_filter_price_end').val();
        $.ajax({
            url: 'ajax_sort_rating_and_keyword',
            method: 'POST',
            data: {
                _token: _token,
                keyword_search: keyword_search,
                sort_rating_fiter: sort_rating_fiter,
                type_filter: type_filter,
                level_filter: level_filter,
                level_filter_price_start: level_filter_price_start,
                level_filter_price_end: level_filter_price_end,
            },
            success: function (data) {
                $('.content_list_product_search').html(data);
            }
        });
    });
    // sort discount
    $('.sort_discount_fiter').change(function(){
        var sort_discount_fiter = $('.sort_discount_fiter option:selected').val();
        var type_filter = $('.type_filter').val();
        var level_filter = $('.level_filter').val();
        var level_filter_price_start = $('.level_filter_price_start').val();
        var level_filter_price_end = $('.level_filter_price_end').val();
        $.ajax({
            url: 'ajax_sort_discount_and_keyword',
            method: 'POST',
            data: {
                _token: _token,
                keyword_search: keyword_search,
                sort_discount_fiter: sort_discount_fiter,
                type_filter: type_filter,
                level_filter: level_filter,
                level_filter_price_start: level_filter_price_start,
                level_filter_price_end: level_filter_price_end,
            },
            success: function (data) {
                $('.content_list_product_search').html(data);
            }
        });
    });

