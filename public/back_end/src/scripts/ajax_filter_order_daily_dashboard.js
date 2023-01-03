$('#date_end_order_daily').change(function(){
    var date_start = $('#date_start_order_daily').val();
    var date_end = $('#date_end_order_daily').val();
    var _token = $('input[name="_token"]').val();
    if(date_start == ''){
        $('#date_start_order_daily').focus();
        Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: 'Bạn chưa nhập ngày bắt đầu',
            showConfirmButton: false,
            timer: 1500
            });
    }else if(date_start > date_end){
        $('#date_start_order_daily').focus();
        $('#date_start_order_daily').val('');
        $('#date_end_order_daily').val('');
        Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: 'Hãy điền khoảng thời gian phù hợp',
            showConfirmButton: false,
            timer: 1500
            });
    }
    else{
        $.ajax({
            url: 'admin/filter_date_daily_order',
            method: 'POST',
            data: {
                date_start: date_start,
                date_end: date_end,
                _token: _token
            },
            success: function (data) {
                 $('.content_filter_daily_order').html(data);
                //alert(data);
            }
        });
    }
});
