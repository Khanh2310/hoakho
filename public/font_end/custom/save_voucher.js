
    $('.btn_save_voucher').click(function () {
        var voucher_id = $(this).attr('data-id');
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: '../process_save_voucher',
            method: 'post',
            data: {
                _token: _token,
                voucher_id: voucher_id
            },
            success: function (data) {
                if(data == 1){
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Vui lòng đăng nhập!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
                if(data == 2){
                    // $('.btn_save_voucher_'+voucher_id).addClass('saved-voucher');
                    // $('.btn_save_voucher_'+voucher_id).prop('disabled', true);
                    $('.btn_saved_voucher_'+voucher_id).css("display", "block");
                    $('.btn_save_voucher_'+voucher_id).css("display", "none");
                }
            }
        });
    });

