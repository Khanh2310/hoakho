$(document).ready(function(){
    var modal_name = $('#modal_name');
    var btn_open_modal = $('.btn_open_modal');
    var btn_close_modal = $('.btn_close_modal');
    btn_open_modal.click(function () {
        modal_name.show();
    });
    btn_close_modal.click(function () {
        modal_order.hide();
    });
    $(window).on('click', function (e) {
        if ($(e.target).is('.modal_name')) {
            modal_name.hide();
        }
    });

    btn_order.click(function () {
        var val_data_id = $(this).attr('data-id');
        $('.push_val_class').val(val_data_id);
    });
    btn_cancel_order.click(function(){
        var val_form_input = $('#val_form_input').val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: '',
            method: 'post',
            data: {
                _token: _token,
                val_form_input: _val_form_input
            },
            success: function (data) {
            }
        });
    });

});
