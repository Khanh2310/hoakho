
    // soft delete voucher
    $('.soft_delete_voucher').click(function(event){
        event.preventDefault();
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
