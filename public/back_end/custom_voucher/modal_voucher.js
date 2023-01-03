$(document).ready(function(){
    // $('.btn_open_modal').click(function(){
    //     var voucher_id = $(this).attr('data-id');
    //     var _token = $('input[name="_token"]').val();
    //     $.ajax({
    //         url: '../get_voucher_id',
    //         method: 'post',
    //         data: {
    //             _token: _token,
    //             voucher_id: voucher_id
    //         },
    //         success: function (data) {
    //             $('.voucher_code').html(data);
    //         }
    //     });
    //     $.ajax({
    //         url: '../get_voucher_name',
    //         method: 'post',
    //         data: {
    //             _token: _token,
    //             voucher_id: voucher_id
    //         },
    //         success: function (data) {
    //             $('.voucher_name').html(data);
    //         }
    //     });
    //     $.ajax({
    //         url: '../get_voucher_product',
    //         method: 'post',
    //         data: {
    //             _token: _token,
    //             voucher_id: voucher_id
    //         },
    //         success: function (data) {
    //             $('.voucher_product').html(data);
    //         }
    //     });
    //     $.ajax({
    //         url: '../get_voucher_start_date',
    //         method: 'post',
    //         data: {
    //             _token: _token,
    //             voucher_id: voucher_id
    //         },
    //         success: function (data) {
    //             $('.voucher_start_date').html(data);
    //         }
    //     });
    //     $.ajax({
    //         url: '../get_voucher_end_date',
    //         method: 'post',
    //         data: {
    //             _token: _token,
    //             voucher_id: voucher_id
    //         },
    //         success: function (data) {
    //             $('.voucher_end_date').html(data);
    //         }
    //     });
    //     $.ajax({
    //         url: '../get_voucher_quantity',
    //         method: 'post',
    //         data: {
    //             _token: _token,
    //             voucher_id: voucher_id
    //         },
    //         success: function (data) {
    //             $('.voucher_quantity').html(data);
    //         }
    //     });
    //     $.ajax({
    //         url: '../get_voucher_amount',
    //         method: 'post',
    //         data: {
    //             _token: _token,
    //             voucher_id: voucher_id
    //         },
    //         success: function (data) {
    //             $('.voucher_amount').html(data);
    //         }
    //     });
    //     $.ajax({
    //         url: '../get_voucher_status',
    //         method: 'post',
    //         data: {
    //             _token: _token,
    //             voucher_id: voucher_id
    //         },
    //         success: function (data) {
    //             $('.voucher_status').html(data);
    //         }
    //     });
    // });


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
                $('.voucher_code').html(data);
            }
        });
    });



    // var modal_voucher_detail = $('#modal_voucher_detail');
    // var btn_open_modal = $('.btn_open_modal');
    // var btn_close_modal = $('.btn_close_modal');
    // btn_open_modal.click(function () {
    //     modal_voucher_detail.show();
    // });
    // btn_close_modal.click(function () {
    //     modal_voucher_detail.hide();
    // });
    // $(window).on('click', function (e) {
    //     if ($(e.target).is('.modal_voucher_detail')) {
    //         modal_voucher_detail.hide();
    //     }
    // });

    // btn_open_modal.click(function(){
    //     var voucher_id = $(this).attr('data-id');
    //     var _token = $('input[name="_token"]').val();
    //     $.ajax({
    //         url: '../get_voucher_id',
    //         method: 'post',
    //         data: {
    //             _token: _token,
    //             voucher_id: voucher_id
    //         },
    //         success: function (data) {
    //             $('.voucher_code').html(data);
    //         }
    //     });
    //     $.ajax({
    //         url: '../get_voucher_name',
    //         method: 'post',
    //         data: {
    //             _token: _token,
    //             voucher_id: voucher_id
    //         },
    //         success: function (data) {
    //             $('.voucher_name').html(data);
    //         }
    //     });
    //     $.ajax({
    //         url: '../get_voucher_product',
    //         method: 'post',
    //         data: {
    //             _token: _token,
    //             voucher_id: voucher_id
    //         },
    //         success: function (data) {
    //             $('.voucher_product').html(data);
    //         }
    //     });
    //     $.ajax({
    //         url: '../get_voucher_start_date',
    //         method: 'post',
    //         data: {
    //             _token: _token,
    //             voucher_id: voucher_id
    //         },
    //         success: function (data) {
    //             $('.voucher_start_date').html(data);
    //         }
    //     });
    //     $.ajax({
    //         url: '../get_voucher_end_date',
    //         method: 'post',
    //         data: {
    //             _token: _token,
    //             voucher_id: voucher_id
    //         },
    //         success: function (data) {
    //             $('.voucher_end_date').html(data);
    //         }
    //     });
    //     $.ajax({
    //         url: '../get_voucher_quantity',
    //         method: 'post',
    //         data: {
    //             _token: _token,
    //             voucher_id: voucher_id
    //         },
    //         success: function (data) {
    //             $('.voucher_quantity').html(data);
    //         }
    //     });
    //     $.ajax({
    //         url: '../get_voucher_amount',
    //         method: 'post',
    //         data: {
    //             _token: _token,
    //             voucher_id: voucher_id
    //         },
    //         success: function (data) {
    //             $('.voucher_amount').html(data);
    //         }
    //     });
    //     $.ajax({
    //         url: '../get_voucher_status',
    //         method: 'post',
    //         data: {
    //             _token: _token,
    //             voucher_id: voucher_id
    //         },
    //         success: function (data) {
    //             $('.voucher_status').html(data);
    //         }
    //     });
    // });
});