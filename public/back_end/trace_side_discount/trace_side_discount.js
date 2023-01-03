// trace storage product
$('#btn_trace_discount_many_date').click(function(){
    $('.content_trace_discount_side_discount_date_single').addClass('dis-none');
    $('.content_trace_discount_side_discount_date_many').removeClass('dis-none');
});
$('#btn_trace_discount_single_date').click(function(){
    $('.content_trace_discount_side_discount_date_single').removeClass('dis-none');
    $('.content_trace_discount_side_discount_date_many').addClass('dis-none');
});
$('#btn_trace_discount_fol_date').click(function(){
    let type_action = $('input[name="type_action_discount_single"]:checked').val();
    let start_date = $('.choose_date_discount_single').val();
    let admin_id = $('#admin_id_single').val();
    let discount_id = $('.discount_id').val();
    let _token = $('input[name="_token"]').val();
    if(start_date == ''){
        Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: 'Vui lòng điền ngày để truy vết',
            showConfirmButton: false,
            timer: 1000
        });
    }
    else{
        $.ajax({
            url: '../trace_discount_side_profile_single_date',
            method: 'post',
            data: {
                _token: _token,
                type_action: type_action,
                start_date: start_date,
                admin_id: admin_id,
                discount_id: discount_id,
            },
            success: function (data) {
                $('#Modal_trace_discount_side_discount').modal('hide');
                $('#content_trace_discount').html(data);
            }
        });
    }
});
$('#btn_trace_discount_fol_date_many').click(function(){
    let type_action = $('input[name="type_action_discount_many"]:checked').val();
    let admin_id = $('#admin_id_many').val();
    let start_date = $('.start_date_discount_many').val();
    let end_date = $('.end_date_discount_many').val();
    let discount_id = $('.discount_id').val();
    let _token = $('input[name="_token"]').val();
    if(start_date == '' || end_date == ''){
        Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: 'Vui lòng điền đầy đủ ngày để truy vết',
            showConfirmButton: false,
            timer: 1500
        });
    }
    else if(start_date >= end_date){
        Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: 'Vui lòng điền ngày phù hợp',
            showConfirmButton: false,
            timer: 1500
        });
    }
    else{
        $.ajax({
            url: '../trace_discount_side_profile_many_date',
            method: 'post',
            data: {
                _token: _token,
                type_action: type_action,
                start_date: start_date,
                end_date: end_date,
                admin_id: admin_id,
                discount_id: discount_id,
            },
            success: function (data) {
                $('#Modal_trace_discount_side_discount').modal('hide');
                $('#content_trace_discount').html(data);
            }
        });
    }
});
