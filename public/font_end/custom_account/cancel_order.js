$(document).ready(function(){
    var modal_order = $('#modal_delete_order');
    var btn_order = $('.btn_open_order_cancel');
    var close_order = $('.close_cancel_order');
    var btn_cancel_order = $('.btn_cancel_order');
    btn_order.click(function () {
        modal_order.show();
    });
    close_order.click(function () {
        modal_order.hide();
    });
    $(window).on('click', function (e) {
        if ($(e.target).is('.modal_order')) {
            modal_order.hide();
        }
    });

    btn_order.click(function () {
        var order_id = $(this).attr('data-id');
        $('.cancel_order').val(order_id);
    });
    btn_cancel_order.click(function(){
        var order_id = $('#order_id').val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: '../process_cancel_order',
            method: 'post',
            data: {
                _token: _token,
                order_id: order_id
            },
            success: function (data) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Hủy đơn hàng thành công',
                    showConfirmButton: false,
                    timer: 1000
                    });
                setTimeout(
                    function(){
                        location.reload();
                    }, 1100);
            }
        });
    });

});
