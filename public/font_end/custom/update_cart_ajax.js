

    var arrCheck = [];

    //function format number
    function formatNumber (num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.")
    }
    //function load value cart
    function loadValCart(cart_id, data, price){
        $('.val_quantity_update_cart_' + cart_id).val(data);
        var total_price = data*price;
        $('.totol_price_cart_item_update_'+ cart_id).html(formatNumber(total_price)+'đ');
        $('.get_total_price_cart_item_check_'+ cart_id).val(total_price);
    }
    //
    function update_qty_when_update_cart(cart_id, _token){
        $.ajax({
            url: 'update_qty_when_update_cart',
            method: 'POST',
            data: {
                _token: _token,
                cart_id: cart_id,
            },
            success: function (data) {
                $('.qty_update_when_change_cart_'+cart_id).val(data);
            }
        });
    }


    // up cart
    $('.btn_up_update_cart').click(function () {
        var cart_id = $(this).attr('data-id');
        var qty = $('.val_quantity_update_cart_' + cart_id).val();
        var old_qty = $('.val_quantity_update_cart_' + cart_id).val();
        var price = $('.val_price_update_cart_' + cart_id).val();
        var _token = $('input[name="_token"]').val();
        qty++;
        $.ajax({
            url: 'update_cart',
            method: 'POST',
            data: {
                cart_id: cart_id,
                qty: qty,
                _token: _token
            },
            success: function (data) {
                if (data == 0) {
                    $('.val_quantity_update_cart_' + cart_id).val(old_qty);
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Rất tiếc, bạn chỉ có thể mua tối đa '+old_qty+ ' sản phẩm.',
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
                else {
                    loadValCart(cart_id, data, price);
                    update_qty_when_update_cart(cart_id, _token);
                }
            }
        });
    });

    // down cart
    $('.btn_down_update_cart').click(function () {
        var cart_id = $(this).attr('data-id');
        var qty = $('.val_quantity_update_cart_' + cart_id).val();
        var old_qty = $('.val_quantity_update_cart_' + cart_id).val();
        var price = $('.val_price_update_cart_' + cart_id).val();
        var _token = $('input[name="_token"]').val();
        if (qty > 1) {
            qty--;
            $.ajax({
                url: 'update_cart',
                method: 'POST',
                data: {
                    cart_id: cart_id,
                    qty: qty,
                    _token: _token
                },
                success: function (data) {
                    if (data == 0) {
                        $('.val_quantity_update_cart_' + cart_id).val(old_qty);
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'cập nhật giỏ hàng thất bại',
                            showConfirmButton: false,
                            timer: 1000
                        });

                    }
                    else {
                        loadValCart(cart_id, data, price);
                        update_qty_when_update_cart(cart_id, _token);
                    }
                }
            });
        }
    });


    // update val on change
    $('.val_update_cart_change').bind('keyup mouseup blur', function () {
       var qty = $(this).val();
       var cart_id = $(this).attr('data-id');
       var price = $('.val_price_update_cart_' + cart_id).val();
       var _token = $('input[name="_token"]').val();
        if(qty != '' && qty != null){
            $.ajax({
                url: 'update_cart',
                method: 'POST',
                data: {
                    cart_id: cart_id,
                    qty: qty,
                    _token: _token
                },
                success: function (data) {
                    if (data == 0) {
                        $(function(){
                            $.ajax({
                                url: 'check_quatity_blur',
                                method: 'POST',
                                data: {
                                    cart_id: cart_id,
                                    _token: _token
                                },
                                success: function (data) {
                                    $('.val_quantity_update_cart_' + cart_id).val(data);
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'error',
                                        title: 'Rất tiếc, bạn chỉ có thể mua tối đa '+data+ ' sản phẩm.',
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                }
                            });
                        });
                    }
                    else{
                        loadValCart(cart_id, data, price);
                        update_qty_when_update_cart(cart_id, _token);
                    }
                }
            });
        }
    });

    // check box cart
    $('.form_checkbox_cart :checkbox').change(function(){

        var arrCheck = [];
        var total_price_all_item_check = 0;


        if($('.check_item_'+$(this).val()).is(':checked')){
            $('.val_quantity_update_cart_'+$(this).val()).prop('readonly', true);
        }
        else{
            $('.val_quantity_update_cart_'+$(this).val()).prop('readonly', false);
        }

        $("input:checkbox[name='itemCart[]']:checked").each(function() {
            arrCheck.push($(this).val());
        });


        for (let i = 0; i < arrCheck.length; i++) {
            var _token = $('input[name="_token"]').val();
            var qty = $('.val_quantity_update_cart_'+arrCheck[i]).val();
            var price = $('.val_price_update_cart_'+arrCheck[i]).val();
            var price_item = Number(qty)*Number(price);
            total_price_all_item_check = total_price_all_item_check + Number(price_item);
        }

        $('.btn_up_update_cart').click(function(){
            var cart_id = $(this).attr('data-id');
            var max_val = $('.max_val_'+cart_id).val();
            var qty = $('.val_quantity_update_cart_'+cart_id).val();
            qty++;
            if($('.check_item_'+cart_id).is(':checked')){
                if(qty <= max_val){
                    var price = $('.val_price_update_cart_'+cart_id).val();
                    total_price_all_item_check = total_price_all_item_check + Number(price);
                    $('.show_total_price_check_item_cart').html(formatNumber(total_price_all_item_check)+'đ');
                    $('.show_total_price_check_item_cart_hidden').val(total_price_all_item_check);
                }
            }
        });
        $('.btn_down_update_cart').click(function(){
                var cart_id = $(this).attr('data-id');
                var qty = $('.val_quantity_update_cart_'+cart_id).val();
                if($('.check_item_'+cart_id).is(':checked')){
                    qty--;
                    if(qty > 0){
                        var price = $('.val_price_update_cart_'+cart_id).val();
                        total_price_all_item_check = total_price_all_item_check - Number(price);
                        $('.show_total_price_check_item_cart').html(formatNumber(total_price_all_item_check)+'đ');
                        $('.show_total_price_check_item_cart_hidden').val(total_price_all_item_check);
                    }
                }
        });

        $('.total_item_cart').html("("+arrCheck.length+" sản phẩm)");
        $('.show_total_price_check_item_cart').html(formatNumber(total_price_all_item_check)+'đ');
        $('.show_total_price_check_item_cart_hidden').val(total_price_all_item_check);


    });
    // process check box all and check each checkbox
    var check_all = $('.check_all');
    var itemCheck = $('.item_check');
    check_all.click(function(){
        var isCheckAll = $(this).prop('checked');
        if(isCheckAll){
            itemCheck.prop('checked', true);
            $('.val_update_cart_change').prop('readonly', true);
        }
        else{
            itemCheck.prop('checked', false);
            $('.val_update_cart_change').prop('readonly', false);
        }

    });
    if(check_all.is(':checked')){
        $('.val_update_cart_change').prop('readonly', true);
        var tota_price_hidden = $('.show_total_price_check_item_cart_hidden').val();
        tota_price_hidden = Number(tota_price_hidden);
        $('.btn_up_update_cart').click(function(){
            var cart_id = $(this).attr('data-id');
            var max_val = $('.max_val_'+cart_id).val();
            var qty = $('.val_quantity_update_cart_'+cart_id).val();
            qty++;
            if($('.check_item_'+cart_id).is(':checked')){
                if(qty <= max_val){
                    var price = $('.val_price_update_cart_'+cart_id).val();
                    tota_price_hidden = tota_price_hidden + Number(price);
                    $('.show_total_price_check_item_cart').html(formatNumber(tota_price_hidden)+'đ');
                    $('.show_total_price_check_item_cart_hidden').val(tota_price_hidden);
                }
            }
        });
        $('.btn_down_update_cart').click(function(){
                var cart_id = $(this).attr('data-id');
                var qty = $('.val_quantity_update_cart_'+cart_id).val();
                if($('.check_item_'+cart_id).is(':checked')){
                    qty--;
                    if(qty > 0){
                        var price = $('.val_price_update_cart_'+cart_id).val();
                        tota_price_hidden = tota_price_hidden - Number(price);
                        $('.show_total_price_check_item_cart').html(formatNumber(tota_price_hidden)+' vnđ');
                        $('.show_total_price_check_item_cart_hidden').val(tota_price_hidden);
                    }
                }
        });
    }
    itemCheck.change(function(){
        var countCheck = itemCheck.length === $('input[name="itemCart[]"]:checked').length;
        if(!countCheck){
            check_all.prop('checked', false);
        }
        else{
            check_all.prop('checked', true);
        }
    });
    // end process checkbox

    // submit form
    $('.submit_form_check_out').click(function (){
        var countCheckItem = $('input[name="itemCart[]"]:checked').length;
        var formCart = document.forms['form_show_cart'];
        if(countCheckItem > 0){
            formCart.submit();
        }
        else{
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Bạn chưa chọn sản phẩm nào để tiến hành đặt hàng !',
                showConfirmButton: false,
                timer: 1500
            });
        }
    });

