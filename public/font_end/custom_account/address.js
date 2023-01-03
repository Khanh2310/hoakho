// function checkName(name, event){
//     if (/\d/.test(name)) {
//         Swal.fire({
//             position: 'top-end',
//             icon: 'error',
//             title: 'Tên không hợp lệ',
//             showConfirmButton: false,
//             timer: 1500
//         });
//         event.preventDefaul();
//     }
// }



    //ADD ADRESS USER
    $('#city_add_address').change(function(){
        var city = $('#city_add_address').val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: '../load_district',
            method: 'POST',
            data: {
                city: city,
                _token: _token
            },
            success: function (data) {
                $('#district_add_address').html(data);
            }
        });
    });
    $('#district_add_address').change(function(){
        var district = $('#district_add_address').val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: '../load_ward',
            method: 'POST',
            data: {
                district: district,
                _token: _token
            },
            success: function (data) {
                $('#ward_add_address').html(data);
            }
        });
    });
    // UPDATE ADDRESS USER
    $('#city_update_address').change(function(){
        var city = $('#city_update_address').val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: '../load_district_update_address_user',
            method: 'POST',
            data: {
                city: city,
                _token: _token
            },
            success: function (data) {
                $('#district_update_address').html(data);
            }
        });
    });
    $('#district_update_address').change(function(){
        var district = $('#district_update_address').val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: '../load_ward_update_address_user',
            method: 'POST',
            data: {
                district: district,
                _token: _token
            },
            success: function (data) {
                $('#ward_update_address').html(data);
            }
        });
    });

    //add customer_address_transport
    $('.btn_add_address').click(function(){
        var fullname = $('.trans_fullname').val();
        var phone = $('.trans_phone').val();
        var city = $('#city_add_address').val();
        var district = $('#district_add_address').val();
        var ward = $('#ward_add_address').val();
        var detail_address = $('#detail_address').val();
        var _token = $('input[name="_token"]').val();
        var check = 1;

        // checkName(fullname);

        if(fullname == "" || phone == "" || city == "" || district == "" || ward == "" || detail_address == ""){
            check = 0;
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Bạn chưa nhập đủ thông tin',
                showConfirmButton: false,
                timer: 1500
              });

        }
        else{
            if(phone.length != 10 || phone.indexOf('0')!==0){
                check = 0;
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Số điện thoại không đúng định dạng',
                    showConfirmButton: false,
                    timer: 1500
                  });
            }
        }
        if(check == 1){
            $.ajax({
                url: '../process_add_address',
                method: 'POST',
                data: {
                    fullname: fullname,
                    phone: phone,
                    city: city,
                    district: district,
                    ward: ward,
                    detail_address: detail_address,
                    _token: _token,
                },
                success: function (data) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Thêm địa chỉ thành công',
                        showConfirmButton: false,
                        timer: 1500
                        });
                    setTimeout(
                        function(){
                            location.reload();
                        }, 1600);
                }
            });
        }
    });

    //DELETE ADDRESS
    $('.delete_address').click(function(){
        var trans_id = $(this).attr('data-id');
        $('.delete_address').val(trans_id);
    });
    $('.btn_delete_address').click(function(){
        var trans_id = $('#trans_id').val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: '../process_delete_address',
            method: 'POST',
            data: {
                trans_id: trans_id,
                _token: _token,
            },
            success: function (data) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Xóa địa chỉ thành công',
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

    //update address
    $('.update_address').click(function(){
        var trans_id = $(this).attr('data-id');
        var _token = $('input[name="_token"]').val();
        $('.trans_id').val(trans_id);
        $.ajax({
            url: '../trans_id_update',
            method: 'post',
            data: {
                _token: _token,
                trans_id: trans_id
            },
            success: function (data) {
                $('.fullname_address_update').val(data);
            }
        });
        $.ajax({
            url: '../get_phone_address',
            method: 'post',
            data: {
                _token: _token,
                trans_id: trans_id
            },
            success: function (data) {
                $('.phone_address_update').val(data);
            }
        });
        $.ajax({
            url: '../get_address_detail_trans',
            method: 'post',
            data: {
                _token: _token,
                trans_id: trans_id
            },
            success: function (data) {
                $('.address_detail_trans_update').val(data);
            }
        });
        $.ajax({
            url: '../get_address_ward_trans',
            method: 'post',
            data: {
                _token: _token,
                trans_id: trans_id
            },
            success: function (data) {
                $('.show_address_ward_trans_update').html(data);
            }
        });
        $.ajax({
            url: '../get_address_district_trans',
            method: 'post',
            data: {
                _token: _token,
                trans_id: trans_id
            },
            success: function (data) {
                $('.show_address_district_trans_update').html(data);
            }
        });
        $.ajax({
            url: '../get_address_city_trans',
            method: 'post',
            data: {
                _token: _token,
                trans_id: trans_id
            },
            success: function (data) {
                $('.show_address_city_trans_update').html(data);
            }
        });
    });

    $('.btn_update_address').click(function(){
        var trans_id = $('.trans_id').val();
        var fullname = $('#trans_fullname').val();
        var phone = $('#trans_phone').val();
        var city = $('#city_update_address').val();
        var district = $('#district_update_address').val();
        var ward = $('#ward_update_address').val();
        var detail_address = $('#detail_update_address').val();
        var _token = $('input[name="_token"]').val();

        // checkName(fullname);

        $.ajax({
            url: '../process_update_address',
            method: 'POST',
            data: {
                trans_id: trans_id,
                fullname: fullname,
                phone: phone,
                city: city,
                district: district,
                ward: ward,
                detail_address: detail_address,
                _token: _token,
            },
            success: function (data) {
                if(data == 1){
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Tên không được để trống',
                        showConfirmButton: false,
                        timer: 1500
                      });
                }
                else if(data == 2){
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Số điện thoại không đúng định dạng',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
                else if(data == 3){
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Số điện thoại phải bắt buộc 10 số',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
                else if(data == 4){
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Số điện thoại không đúng định dạng',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
                else if(data == 5){
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Địa chị cụ thể không được để trống',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
                else if(data == 7){
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Quận/Huyện không được để trống',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
                else if(data == 8){
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Xã/Thị Trấn không được để trống',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
                else if(data == 6 || data == 9){
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Sửa địa chỉ thành công',
                        showConfirmButton: false,
                        timer: 1500
                        });
                    setTimeout(
                        function(){
                            location.reload();
                        }, 1600);
                }
            }
        });
    });

