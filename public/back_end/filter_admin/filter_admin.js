$('.btn_filter_role').click(function(){
    let role_id = $(this).attr('data-id');
    let _token = $('input[name="_token"]').val();
    $.ajax({
        url: 'filter_admin_role',
        method: 'post',
        data: {
            _token: _token,
            role_id: role_id,
        },
        success: function (data) {
            $('.content_filter_admin').html(data);
        }
    });
});
