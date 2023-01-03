
    $("#val_find_shipping_cost").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#table_find_shipping_cost tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    // DELETE SHIPPING COST
    $('.delete_shipping_cost').click(function(){
        var shipping_cost_id = $(this).attr('data-id');
        $('.shipping_cost_id').val(shipping_cost_id);
    });
    $('.btn_delete').click(function(){
        var form_delete = document.forms['form_delete_shipping_cost'];
        form_delete.submit();
    });

    // SEARCH
    $('#find_shipping_cost').keyup(function(){
        var value_find = $('#find_shipping_cost').val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: 'find_shipping_cost',
            method: 'post',
            data: {
                value_find: value_find,
                _token: _token,
            },
            success: function (data) {
                $('.content_find_shipping_cost').html(data);
            }
        });
    });
