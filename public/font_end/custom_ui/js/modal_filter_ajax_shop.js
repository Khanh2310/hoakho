$(document).ready(function(){
    var modal_filter = $('.modal_filter');
    var btn_open_modal_filter = $('.btn_open_modal_filter');
    var close_modal = $('.close_modal_filter');
    var btn_back_modal = $('.btn_back_modal');
    btn_open_modal_filter.click(function () {
        modal_filter.show();
    });
    close_modal.click(function () {
        modal_filter.hide();
    });
    $(window).on('click', function (e) {
        if ($(e.target).is('.modal_filter')) {
            modal_filter.hide();
        }
    });
    btn_back_modal.click(function () {
        modal_filter.hide();
    });

    var _token = $('input[name="_token"]').val();
    //filter modal
    $('.btn_filter_modal_shop_many_feature').click(function (){
        var cate_id = $('.select_cate_to_filter option:selected').val();
        var rating = $('.select_rating_to_filter option:selected').val();
        var price_start_filter = Number($('.price_start_filter').val());
        var price_end_filter = Number($('.price_end_filter').val());

        var checkPrice = 1;
        if(price_start_filter == 0 && price_end_filter == 0 && cate_id == '' && rating == 0){
            checkPrice = 0;
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Bạn chưa điền thông tin Lọc',
                showConfirmButton: false,
                timer: 2000
            });
        }
        else if(price_start_filter != 0 && price_end_filter != 0){
            if(price_start_filter >= price_end_filter || price_start_filter < 0){
                checkPrice = 0;
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Vui lòng điền khoảng giá phù hợp',
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        }
        else if(price_start_filter != 0 && price_end_filter == 0){
            checkPrice = 0;
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Vui lòng điền khoảng giá phù hợp',
                showConfirmButton: false,
                timer: 2000
            });
        }
        else if(price_start_filter == 0 && price_end_filter != 0){
            checkPrice = 0;
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Vui lòng điền khoảng giá phù hợp',
                showConfirmButton: false,
                timer: 2000
            });
        }

        if(checkPrice == 1){
            $.ajax({
                url: 'filter_modal_shop_ajax',
                method: 'POST',
                data: {
                    _token: _token,
                    cate_id: cate_id,
                    rating: rating,
                    price_start_filter:price_start_filter,
                    price_end_filter:price_end_filter
                },
                success: function (data) {
                    $('.content_list_product_sort_ajax_shop').html(data);
                    $('.modal_filter').hide();
                    //
                    $('.check_cus_price').removeClass('selected');
                    $('.check_cus_cate').removeClass('selected');
                    $('.val_price_sort_start').val('');
                    $('.val_price_sort_end').val('');
                    //
                }
            });
        }


    });
});


