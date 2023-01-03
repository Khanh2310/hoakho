
    $('#btn_filter_comment_fol_product').click(function(){
        let product_id = $('#product_id :selected').val();
        let _token = $('input[name="_token"]').val();
        if(product_id == ''){
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Vui lòng chọn sản phẩm cần lọc',
                showConfirmButton: false,
                timer: 1500
            });
        }
        else{
            $.ajax({
                url: 'filter_comment_fol_product',
                method: 'post',
                data: {
                    _token: _token,
                    product_id: product_id,
                },
                success: function (data) {
                    $('.content_filter_comment').html(data);
                    $('#Modal_filter_comment_follow_product').modal('hide');
                }
            });
        }

    });

    $('#btn_filter_comment_fol_rating_many').click(function(){
        let rating = $('input[name="rating"]:checked').val();
        let _token = $('input[name="_token"]').val();
        if(rating){
            $.ajax({
                url: 'filter_comment_fol_rating',
                method: 'post',
                data: {
                    _token: _token,
                    rating: rating,
                },
                success: function (data) {
                    $('.content_filter_comment').html(data);
                    $('#Modal_filter_comment_follow_rating').modal('hide');
                }
            });
        }
        else{

            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Vui lòng chọn đánh giá cần lọc',
                showConfirmButton: false,
                timer: 1500
            });
        }
    });

