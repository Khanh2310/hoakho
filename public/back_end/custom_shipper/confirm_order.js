$('.btn_confirm_order').click(function(){
    var order_code = $(this).attr('data-id');
    $('.val_order_code').val(order_code);
});

$('.btn_confirm_modal').click(function(){
    var form_submit_confirm = document.forms['form_submit_confirm'];
    form_submit_confirm.submit();
});

$('.btn_confirm_order_fail').click(function(){
    var order_code = $(this).attr('data-id');
    $('.val_order_code').val(order_code);
});

$('.btn_confirm_modal_fail').click(function(){
    var form_submit_confirm = document.forms['form_submit_confirm_fail'];
    form_submit_confirm.submit();
});

$('.close').click(function(){
    $("div.alert").delay(500).fadeOut();;
});