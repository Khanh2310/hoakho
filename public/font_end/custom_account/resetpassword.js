$(document).ready(function(){
    // RESETPASSWORD
    $('.btn_confirm_resetpassword').click(function(){
        var password_old = $('.password_old').val();
        var password_new = $('.password_new').val();
        var password_new_confirmation = $('.password_new_confirmation').val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: '../process_update_password_account',
            method: 'POST',
            data: {
                password_old: password_old,
                password_new: password_new,
                password_new_confirmation: password_new_confirmation,
                _token: _token,
            },
            success: function (data) {
                if(data == 1){
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Mật khẩu không được để trống',
                        showConfirmButton: false,
                        timer: 1500
                      });
                }
                else if(data == 2){
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Mật khẩu không đúng',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
                else if(data == 3){
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Bạn chưa điền mật khẩu mới',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
                else if(data == 4){
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Mật khẩu mới tối đa 8 ký tự',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
                else if(data == 5){
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Bạn chưa xác nhận mật khẩu',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
                else if(data == 6){
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Mật khẩu xác nhận không khớp',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
                else if(data == 7){
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'thay đổi mật khẩu thành công',
                        showConfirmButton: false,
                        timer: 2500
                        });
                    setTimeout(
                        function(){
                            location.reload();
                        }, 2500);
                }
            }
        });
    });
});