<div class="col-lg-8 col-md-8 hidden-sm hidden-xs">
    <div class="header-search-bar layout-01" style="height: 46px;">
        <form action="{{ URL::to('search_product_form_search_auto_complete') }}" class="form-search" name="form_search_product" method="post">
            @csrf
            <input type="text" name="search_product" class="input-text input_search_auto_complete" value="" placeholder="Tìm sản phẩm mong muốn..." autocomplete="off">
            <button type="button" class="btn-submit submit_form"><i class="biolife-icon icon-search"></i></button>
        </form>
    </div>
</div>
<script src="{{ asset('public/font_end/assets/js/jquery-3.4.1.min.js') }}"></script>
<script>
    $(document).ready(function(){
    var val_search_auto_complte = $('.input_search_auto_complete').val();
    $('.input_search_auto_complete').focus(function(){
        $('.content_auto_complete_search').removeClass('dis_none');
    });
    //
    $('.input_search_auto_complete').keyup(function(){
        val_search_auto_complte = $('.input_search_auto_complete').val();
        if(val_search_auto_complte != ""){
            $('.text_question').addClass('dis_none');
            $('.content_search').removeClass('dis_none');
            $('.txt_val_search').html(val_search_auto_complte);

            // ajax val
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: '{{ URL::to('ajax_search_auto_complete') }}',
                method: 'POST',
                data: {
                    _token: _token,
                    val_search_auto_complte: val_search_auto_complte,
                },
                success: function (data) {
                    $('.content_item').html(data);
                }
            });
        }
        else{
            $('.text_question').removeClass('dis_none');
            $('.content_search').addClass('dis_none');
        }
    });
    $('.input_search_auto_complete').focusout(function(){
        if(val_search_auto_complte == ""){
            $('.content_auto_complete_search').addClass('dis_none');
        }
    });

    $('.submit_form').click(function(){
        var val_search = $('.input_search_auto_complete').val();
        if(val_search == ""){
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Bạn chưa nhập từ khóa cần tìm',
                showConfirmButton: false,
                timer: 1500
            });
        }
        else{
            var form_submit = document.forms['form_search_product'];
            form_submit.submit();
        }
    })

});
</script>

