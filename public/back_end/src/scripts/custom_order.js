
    $('.btn_confirm_order').click(function(){
        var order_code = $(this).attr('data-id');
        $('.modal_body').html('Xác nhận đơn hàng "<b>#'+order_code+'</b>" ?');
        $('.val_order_code').val(order_code);
    });

    $('.btn_confirm_modal').click(function(){
        var form_submit_confirm_order = document.forms['form_submit_confirm_order'];
        form_submit_confirm_order.submit();
    });
    //
    $('.btn_confirm_delivery_order').click(function(){
        var order_code = $(this).attr('data-id');
        $('.modal_body_delivary').html('Xác nhận giao đơn hàng "<b>#'+order_code+'</b>" ?');
        $('.val_order_code').val(order_code);
    });

    $('.btn_confirm_delivery_modal').click(function(){
        var form_submit_confirm_delivary_order = document.forms['form_submit_confirm_delivary_order'];
        form_submit_confirm_delivary_order.submit();
    });
    //
    $('.btn_confirm_delivery_success_order').click(function(){
        var order_code = $(this).attr('data-id');
        $('.modal_body_delivary_success').html('Xác nhận giao thành công "<b>#'+order_code+'</b>" ?');
        $('.val_order_code').val(order_code);
    });

    $('.btn_confirm_delivery_success_modal').click(function(){
        var form_submit_confirm_delivary_success_order = document.forms['form_submit_confirm_delivary_success_order'];
        form_submit_confirm_delivary_success_order.submit();
    });

    // search
    $("#mySearch").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#table_search tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    // find ajax
    $('#search_order').keyup(function(){
        var search_order = $('#search_order').val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: 'search_order',
            method: 'POST',
            data: {
                search_order: search_order,
                _token: _token
            },
            success: function (data) {
                $('.content_find_order').html(data);
            }
        });
    });
    $('#search_order').keydown(function(){
        var search_order = $('#search_order').val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: 'search_order',
            method: 'POST',
            data: {
                search_order: search_order,
                _token: _token
            },
            success: function (data) {
                $('.content_find_order').html(data);
            }
        });
    });

    // order_detail modal
    $('.btn_confirm_order_mini').click(function(){
        var order_code = $(this).attr('data-id');
        $('.modal_body_confirm_order_mini').html('Xác nhận đơn hàng "<b>#'+order_code+'</b>" ?');
        $('.val_order_code_confirm_order_mini').val(order_code);
    });

    $('.btn_comfirm_modal_confirm_order_mini').click(function(){
        var form_submit_confirm_order_mini = document.forms['form_submit_confirm_order_mini'];
        form_submit_confirm_order_mini.submit();
    });
    // order_detail delivery modal
    $('.btn_confirm_delivery_order_mini').click(function(){
        var order_code = $(this).attr('data-id');
        $('.modal_body_confirm_delivery_order_mini').html('Xác nhận giao đơn hàng "<b>#'+order_code+'</b>" ?');
        $('.val_order_code_confirm_delivery_order_mini').val(order_code);
    });

    $('.btn_comfirm_modal_confirm_delivery_order_mini').click(function(){
        var form_submit_confirm_delivery_order_mini = document.forms['form_submit_confirm_delivery_order_mini'];
        form_submit_confirm_delivery_order_mini.submit();
    });
    // order_detail delivery success modal
    $('.btn_confirm_delivery_order_success_mini').click(function(){
        var order_code = $(this).attr('data-id');
        $('.modal_body_confirm_delivery_order_success_mini').html('Xác nhận đơn hàng giao thành công "<b>#'+order_code+'</b>" ?');
        $('.val_order_code_confirm_delivery_order_success_mini').val(order_code);
    });

    $('.btn_comfirm_modal_confirm_delivery_order_success_mini').click(function(){
        var form_submit_confirm_delivery_order_success_mini = document.forms['form_submit_confirm_delivery_order_success_mini'];
        form_submit_confirm_delivery_order_success_mini.submit();
    });

