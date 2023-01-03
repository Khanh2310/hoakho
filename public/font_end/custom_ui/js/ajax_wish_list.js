
    var _token = $('input[name="_token"]').val();
    $('.btn_add_wish_lish').click(function (){
        var product_id = $(this).attr('data-id');
        $.ajax({
            url: 'add_wish_list_ajax',
            method: 'POST',
            data: {
                _token: _token,
                product_id: product_id,
            },
            success: function (data) {
                if(data == 1){
                    loadWishList(_token);
                    countTotalWishList(_token);
                    $('.icon_wish_list_'+product_id).css('color','#eb7e82');
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Thêm vào danh sách yêu thích thành công',
                        showConfirmButton: false,
                        timer: 1000
                    });
                }
            }
        });
    });

    function loadWishList(_token){
        $.ajax({
            url: 'load_wish_list_ajax',
            method: 'POST',
            data: {
                _token: _token,
            },
            success: function (data) {
                $('.show_mini_wish_list_when_add').html(data);
            }
        });
    }
    function countTotalWishList(_token){
        $.ajax({
            url: 'count_total_wish_list_ajax',
            method: 'POST',
            data: {
                _token: _token,
            },
            success: function (data) {
                $('.total_quantity_wishlist').html(data);
            }
        });
    }

    var btn_open_modal_delete_wishlist = $('.btn_open_modal_delete_wishlist');
    var modal_delete_item_wishlist = $('.modal_delete_item_wishlist');
    var close_modal = $('.close_modal');
    var btn_cancel_modal_delete_item_cart = $('.btn_cancel_modal_delete_item_cart');
    btn_open_modal_delete_wishlist.click(function () {
        modal_delete_item_wishlist.show();
    });
    close_modal.click(function () {
        modal_delete_item_wishlist.hide();
    });
    $(window).on('click', function (e) {
        if ($(e.target).is('.modal_filter')) {
            modal_delete_item_wishlist.hide();
        }
    });
    btn_cancel_modal_delete_item_cart.click(function () {
        modal_delete_item_wishlist.hide();
    });
    //

    btn_open_modal_delete_wishlist.click(function (){
        var wish_list_id = $(this).attr('data-id');
        $('.val_delete_item_wishlist').val(wish_list_id);
    });
    $('.btn_confirm_delete_item_wish_list').click(function () {
        var form_delete = document.forms['form_delete_item_wishlist'];
        form_delete.submit();
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Xóa thành công',
            showConfirmButton: false,
            timer: 1500
            });
        setTimeout(
            function(){
                location.reload();
            }, 1600);
    });
