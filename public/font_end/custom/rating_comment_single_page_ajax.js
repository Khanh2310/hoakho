
function load_comment(_token,product_id){
    $.ajax({
            url: '../load_comment',
            method: 'POST',
            data: {
                _token: _token,
                product_id: product_id,
            },
            success: function (data) {
                $('.content_comment_rating').html(data);
                $('.comment_message').val("");
            }
        });
}
    $('.load_more_comment').click(function(){
        var all_comment_to_count = $('.all_comment_to_count').val();
        //var val_load_add = $('.val_load_add_5').val(); // get biến toàn cục
        var _token = $('input[name="_token"]').val();
        var product_id = $('.val_product_id').val();
        val_load_add = Number(val_load_add) + 5;
        $.ajax({
            url: '../load_more_comment',
            method: 'POST',
            data: {
                _token: _token,
                val_load_add: val_load_add,
                product_id: product_id,
            },
            success: function (data) {
                if(all_comment_to_count < val_load_add){
                    $('.load_more_comment').addClass('op-0');
                }
                $('.content_comment_rating').html(data);
                $('.val_load_add_5').val(val_load_add)
            }
        });

    });
    $('.btn_useful_comment').click(function(){
        var _token = $('input[name="_token"]').val();
        var comment_id = $(this).attr('data-id');

        var check_like = $('.hidden_check_comment_like_'+comment_id).val();
        if(check_like == ""){
            $('.btn_useful_comment_'+comment_id).css('color','#7faf51');
            $('.hidden_check_comment_like_'+comment_id).val(comment_id);
        }
        else{
            $('.btn_useful_comment_'+comment_id).css('color','#666666');
            $('.hidden_check_comment_like_'+comment_id).val('');
        }

        $.ajax({
            url: '../like_comment',
            method: 'POST',
            data: {
                _token: _token,
                comment_id: comment_id,
            },
            success: function (data) {
                $('.txt_count_comment_useful_'+comment_id).html('Hữu ích ('+data+')');

            }
        });
    });

    // MODAL ADD ADDRESS
    var modal_delete_comment = $('.modal_delete_comment');
    var btn_open_modal_delete_comment = $('.btn_open_modal_delete_comment');
    var close_modal_delete_comment = $('.close_modal_delete_comment');
    var btn_back_modal_address = $('.btn_back_modal_address');
    btn_open_modal_delete_comment.click(function () {
        modal_delete_comment.show();
    });
    close_modal_delete_comment.click(function () {
        modal_delete_comment.hide();
    });
    $(window).on('click', function (e) {
        if ($(e.target).is('.modal_address')) {
            modal_delete_comment.hide();
        }
    });
    btn_back_modal_address.click(function () {
        modal_delete_comment.hide();
    });

    //delete comment
    $('.btn_delete_comment').click(function(){
        var comment_id = $(this).attr('data-id');
        $('.val_hidden_comment_to_delete').val(comment_id);
    });
    $('.btn_confirm_delete_comment').click(function(){
        var product_id = $('.val_product_id').val();
        var _token = $('input[name="_token"]').val();
        var comment_id = $('.val_hidden_comment_to_delete').val();
        $.ajax({
            url: '../delete_comment',
            method: 'POST',
            data: {
                _token: _token,
                comment_id: comment_id,
            },
            success: function () {
                load_comment(_token,product_id);
                modal_delete_comment.hide();
                var all_comment_to_count = $('.all_comment_to_count').val();
                var count_comment = Number(all_comment_to_count)-1;
                $('.count_comment_tab').html('('+count_comment+')');
                $('.count_comment_rating').html(count_comment+' đánh giá');
                $('.all_comment_to_count').val(count_comment);
                $('.count_comment_on_detail').html('('+count_comment+' đánh giá)');
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Xóa đánh giá thành công',
                    showConfirmButton: false,
                    timer: 1000
                  });

            }
        });
    })

    // update comment
    $('.btn_update_comment').click(function(){
        var comment_id = $(this).attr('data-id');
        $('.comment_message_'+comment_id).addClass('hidden_comment_message');
        $('.content_area_update_comment_'+comment_id).addClass('show_update_comment');
    });
    $('.btn_huy_update_comment').click(function(){
        var comment_id = $(this).attr('data-id');
        var old_comment = $('.comment_message_'+comment_id).html();
        $('.area_update_comment_'+comment_id).val(old_comment);
        $('.comment_message_'+comment_id).removeClass('hidden_comment_message');
        $('.content_area_update_comment_'+comment_id).removeClass('show_update_comment');
    })
    $('.btn_confirm_update_comment').click(function(){
        var comment_id = $(this).attr('data-id');
        var product_id = $('.val_product_id').val();
        var _token = $('input[name="_token"]').val();
        var comment_message =  $('.area_update_comment_'+comment_id).val();
        $.ajax({
            url: '../update_comment',
            method: 'POST',
            data: {
                _token: _token,
                comment_id: comment_id,
                comment_message: comment_message,
            },
            success: function () {
                load_comment(_token,product_id);
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Chỉnh sửa đánh giá thành công',
                    showConfirmButton: false,
                    timer: 1000
                  });
            }
        });
    });



