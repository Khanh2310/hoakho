
    $('.btn_open_modal').click(function(){
        var voucher_id = $(this).attr('data-id');
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: '../get_voucher_id',
            method: 'post',
            data: {
                _token: _token,
                voucher_id: voucher_id
            },
            success: function (data) {
                $('.content_detail_voucher_ajax').html(data);
            }
        });
    });

    //search voucher
    $('#find_product_voucher').keyup(function(){
        var value_find = $('#find_product_voucher').val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: 'find_product_voucher',
            method: 'get',
            data: {
                value_find: value_find,
                _token: _token
            },
            success: function (data) {
                $('.content_find_product_voucher').html(data);
            }
        });
    });

    //search voucher
    $('#find_voucher').keyup(function(){
        var value_find = $('#find_voucher').val();
        var _token = $('input[name="_token"]').val();
        var product_id = $('#product_id').val();
        $.ajax({
            url: '../find_voucher',
            method: 'post',
            data: {
                value_find: value_find,
                _token: _token,
                product_id: product_id
            },
            success: function (data) {
                $('.content_find_voucher').html(data);
            }
        });
    });

    // soft delete voucher
    $('.soft_delete_voucher').click(function(){
        var voucher_id = $(this).attr('data-id');
        $('.id_delete_voucher').val(voucher_id);
    });
    $('.btn_delete_forever').click(function(){
        var voucher_id = $(this).attr('data-id');
        $('.id_delete_forever_voucher').val(voucher_id);
    });
    $('.btn_confirm_delete_forever').click(function(){
        var form_delete = document.forms['form_delete_forever'];
        form_delete.submit();
    });
