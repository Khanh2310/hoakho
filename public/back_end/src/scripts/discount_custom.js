
    var arrCheck = [];
    //function
    function check_val_tag(){
        var val_discount_product_tag = $('.list_product_discount').val();
        if(val_discount_product_tag != ''){
            $('.content_val_tag_input').removeClass('op-0');
            $('.annouce_tag').addClass('dis_none');
            $('.content_btn_add_discount_product').removeClass('dis_none');
            $('.content_btn_update_discount_product').removeClass('dis_none');
            $('.title_tag_input').removeClass('dis_none');
        }
        else{
            $('.content_val_tag_input').addClass('op-0');
            $('.annouce_tag').removeClass('dis_none');
            $('.content_btn_add_discount_product').addClass('dis_none');
            $('.content_btn_update_discount_product').addClass('dis_none');
        }
    }
    function formatNumber (num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.")
    }
    //
    $('.check').change(function(){
        var isCheck = $(this).prop('checked');
        if(isCheck){
            $('.list_product_discount').tagsinput('add', $(this).val());
        }
        else{
            $('.list_product_discount').tagsinput('remove', $(this).val());
        }
        check_val_tag();

    });
    $('.form_checkbox_discount_product :checkbox').change(function(){
        arrCheck = [];
        var checkAll = $('.checkAll').prop('checked');
        if(checkAll){
            $('.check').prop('checked', true);
        }
        $("input:checkbox[name='Product[]']:checked").each(function() {
            arrCheck.push($(this).val());
        });
        for(var i = 0; i<arrCheck.length; i++){
            $('.list_product_discount').tagsinput('add', arrCheck[i]);
        }
        check_val_tag();
    });
    $('.checkAll').click(function(){
        var checkAll = $('.checkAll').prop('checked');
        if(!checkAll){
            $('.check').prop('checked', false);
            $('.list_product_discount').tagsinput('removeAll');
        }
        check_val_tag();
    });

    //
    $('.check').click(function(){
        var countCheck = $('.check').length === $('input[name="Product[]"]:checked').length;
        if(!countCheck){
            $('.checkAll').prop('checked', false);
        }
        else{
            $('.checkAll').prop('checked', true);
        }
    });
    $(".list_product_discount").on('itemRemoved', function(event) {
        check_val_tag();
        //alert(event.item);
        var val_remove = event.item.replace( /\s/g, '');
        var val_tag = $('.check_'+val_remove).val();
        if(val_tag == event.item){
            $('.check_'+val_remove).prop('checked', false);
            var countCheck = $('.check').length === $('input[name="Product[]"]:checked').length;
            if(!countCheck){
                $('.checkAll').prop('checked', false);
            }
            else{
                $('.checkAll').prop('checked', true);
            }
        }
    })
    // check button to submit form
    $('.btn_add_discount_product').click(function(){
        var time_start_1 = $('.time_start_1').val();
        var time_end_1 = $('.time_end_1').val();
        var condition_discount_1 = $("select.condition_discount_1 option").filter(":selected").val();
        var amount_discount_1 = $('.amount_discount_1').val();
        var time_start_2 = $('.time_start_2').val();
        var time_end_2 = $('.time_end_2').val();
        var condition_discount_2 = $("select.condition_discount_2 option").filter(":selected").val();
        var amount_discount_2 = $('.amount_discount_2').val();

        var form_add_discount = document.forms['form_add_discount'];
        if(time_start_1 == "" || time_end_1 == "" || condition_discount_1 == "" || amount_discount_1 == ""){
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Bạn chưa điền đủ thông tin của mã giảm giá 1',
                showConfirmButton: false,
                timer: 1500
                });

        }
        else if(time_start_2 == "" && time_end_2 == "" && condition_discount_2 == "" && amount_discount_2 == ""){

            check_val(
                time_start_1,
                time_end_1,
                condition_discount_1,
                amount_discount_1,
                time_start_2,
                time_end_2,
                condition_discount_2,
                amount_discount_2,
                arrCheck
            );
        }
        else if(time_start_2 != "" && time_end_2 != "" && condition_discount_2 != "" && amount_discount_2 != ""){
            check_val(
                time_start_1,
                time_end_1,
                condition_discount_1,
                amount_discount_1,
                time_start_2,
                time_end_2,
                condition_discount_2,
                amount_discount_2,
                arrCheck
            );
        }
        else{
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Bạn chưa điền đủ thông tin của mã giảm giá 2',
                showConfirmButton: false,
                timer: 1500
                });
        }
    });

    //btn update discount
    $('.btn_update_discount_product').click(function(){
        var time_start_1 = $('.time_start_1').val();
        var time_end_1 = $('.time_end_1').val();
        var condition_discount_1 = $("select.condition_discount_1 option").filter(":selected").val();
        var amount_discount_1 = $('.amount_discount_1').val();
        var time_start_2 = $('.time_start_2').val();
        var time_end_2 = $('.time_end_2').val();
        var condition_discount_2 = $("select.condition_discount_2 option").filter(":selected").val();
        var amount_discount_2 = $('.amount_discount_2').val();
        var discount_id = $('.val_hidden_discount_id').val();


        var form_update_discount = document.forms['form_update_discount'];
        if(time_start_1 == "" || time_end_1 == "" || condition_discount_1 == "" || amount_discount_1 == ""){
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Bạn chưa điền đủ thông tin của mã giảm giá 1',
                showConfirmButton: false,
                timer: 1500
                });

        }
        else if(time_start_2 == "" && time_end_2 == "" && condition_discount_2 == "" && amount_discount_2 == ""){
            check_val_update(
                time_start_1,
                time_end_1,
                condition_discount_1,
                amount_discount_1,
                time_start_2,
                time_end_2,
                condition_discount_2,
                amount_discount_2,
                arrCheck,
                discount_id
            );
        }
        else if(time_start_2 != "" && time_end_2 != "" && condition_discount_2 != "" && amount_discount_2 != ""){
            check_val_update(
                time_start_1,
                time_end_1,
                condition_discount_1,
                amount_discount_1,
                time_start_2,
                time_end_2,
                condition_discount_2,
                amount_discount_2,
                arrCheck,
                discount_id
            );
        }
        else{
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Bạn chưa điền đủ thông tin của mã giảm giá 2',
                showConfirmButton: false,
                timer: 1500
                });
        }
    });

    // search product to discount
    // $('.search_product_discount').keyup(function(){
    //     var value_find = $('.search_product_discount').val();
    //     var _token = $('input[name="_token"]').val();
    //     $.ajax({
    //         url: 'search_product_discount',
    //         method: 'POST',
    //         data: {
    //             value_find: value_find,
    //             _token: _token
    //         },
    //         success: function (data) {
    //             $('.content_find_product_discount').html(data);
    //         }
    //     });
    // });
    // $('.search_product_discount').keydown(function(){
    //     var value_find = $('.search_product_discount').val();
    //     var _token = $('input[name="_token"]').val();
    //     $.ajax({
    //         url: 'search_product_discount',
    //         method: 'POST',
    //         data: {
    //             value_find: value_find,
    //             _token: _token
    //         },
    //         success: function (data) {
    //             $('.content_find_product_discount').html(data);
    //         }
    //     });
    // });

    // search product discount
    $("#search_product_discount_add").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#table_add_discount tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
    $("#search_product_discount_update").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#table_update_discount tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
    $("#search_all_discount").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#table_all_discount tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
    ///
    function check_val(
        time_start_1,
        time_end_1,
        condition_discount_1,
        amount_discount_1,
        time_start_2,
        time_end_2,
        condition_discount_2,
        amount_discount_2,
        arrCheck
        ){
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: 'check_val_discount',
                method: 'post',
                data: {
                    _token: _token,
                    time_start_1: time_start_1,
                    time_end_1: time_end_1,
                    condition_discount_1: condition_discount_1,
                    amount_discount_1: amount_discount_1,
                    time_start_2: time_start_2,
                    time_end_2: time_end_2,
                    condition_discount_2: condition_discount_2,
                    amount_discount_2: amount_discount_2,
                    arrCheck: arrCheck,
                },
                success: function (data) {
                    if(data == 1){
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Thời gian của mã giảm giá không hợp lệ',
                            showConfirmButton: false,
                            timer: 1500
                            });

                    }
                    else if(data == 2){
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Lượng giảm không hợp lệ',
                            showConfirmButton: false,
                            timer: 1500
                            });
                    }
                    else if(data == 3){
                        check_val_2(
                            time_start_2,
                            time_end_2,
                            condition_discount_2,
                            amount_discount_2,
                            arrCheck
                        )

                    }
                    else{
                        if(amount_discount_1 > Number(data) || amount_discount_1 < 1000 ){
                            Swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: 'Bạn chỉ giảm tối thiểu 1000vnđ và tối đa < '+formatNumber(data)+ 'vnđ',
                                showConfirmButton: false,
                                timer: 2000
                                });
                        }
                        else{
                            check_val_2(
                                time_start_2,
                                time_end_2,
                                condition_discount_2,
                                amount_discount_2,
                                arrCheck
                            )
                        }

                    }
                }
            });
    }
    function check_val_2(
        time_start_2,
        time_end_2,
        condition_discount_2,
        amount_discount_2,
        arrCheck
        ){
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: 'check_val_discount_2',
                method: 'post',
                data: {
                    _token: _token,
                    time_start_2: time_start_2,
                    time_end_2: time_end_2,
                    condition_discount_2: condition_discount_2,
                    amount_discount_2: amount_discount_2,
                    arrCheck: arrCheck,
                },
                success: function (data) {
                    if(data == 1){
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Thời gian của mã giảm 2 giá không hợp lệ',
                            showConfirmButton: false,
                            timer: 1500
                            });

                    }
                    else if(data == 2){
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Lượng giảm không hợp lệ',
                            showConfirmButton: false,
                            timer: 1500
                            });
                    }
                    else if(data == 3){
                        form_add_discount.submit();
                    }
                    else{
                        if(amount_discount_2 > Number(data) || amount_discount_2 < 1000 ){
                            Swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: 'Bạn chỉ giảm tối thiểu 1000vnđ và tối đa < '+formatNumber(data)+ 'vnđ',
                                showConfirmButton: false,
                                timer: 2000
                                });
                        }
                        else{
                            form_add_discount.submit();
                        }

                    }

                }
            });
    }

    // update
    function check_val_update(
        time_start_1,
        time_end_1,
        condition_discount_1,
        amount_discount_1,
        time_start_2,
        time_end_2,
        condition_discount_2,
        amount_discount_2,
        arrCheck,
        discount_id
        ){
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: '../check_val_discount_update',
                method: 'post',
                data: {
                    _token: _token,
                    time_start_1: time_start_1,
                    time_end_1: time_end_1,
                    condition_discount_1: condition_discount_1,
                    amount_discount_1: amount_discount_1,
                    time_start_2: time_start_2,
                    time_end_2: time_end_2,
                    condition_discount_2: condition_discount_2,
                    amount_discount_2: amount_discount_2,
                    arrCheck: arrCheck,
                    discount_id: discount_id,
                },
                success: function (data) {
                    if(data == 1){
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Thời gian của mã giảm giá không hợp lệ',
                            showConfirmButton: false,
                            timer: 1500
                            });

                    }
                    else if(data == 2){
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Lượng giảm không hợp lệ',
                            showConfirmButton: false,
                            timer: 1500
                            });
                    }
                    else if(data == 3){
                        check_val_update_2(
                            time_start_2,
                            time_end_2,
                            condition_discount_2,
                            amount_discount_2,
                            arrCheck,
                            discount_id
                        )
                    }
                    else{
                        if(amount_discount_1 > Number(data) || amount_discount_1 < 1000 ){
                            Swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: 'Bạn chỉ giảm tối thiểu 1000vnđ và tối đa < '+formatNumber(data)+ 'vnđ',
                                showConfirmButton: false,
                                timer: 2000
                                });
                        }
                        else{
                            check_val_update_2(
                                time_start_2,
                                time_end_2,
                                condition_discount_2,
                                amount_discount_2,
                                arrCheck,
                                discount_id
                            )
                        }

                    }

                }
            });
    }
    function check_val_update_2(
        time_start_2,
        time_end_2,
        condition_discount_2,
        amount_discount_2,
        arrCheck,
        discount_id
        ){
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: '../check_val_discount_update_2',
                method: 'post',
                data: {
                    _token: _token,
                    time_start_2: time_start_2,
                    time_end_2: time_end_2,
                    condition_discount_2: condition_discount_2,
                    amount_discount_2: amount_discount_2,
                    arrCheck: arrCheck,
                    discount_id: discount_id,
                },
                success: function (data) {
                    if(data == 1){
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Thời gian của mã giảm giá không hợp lệ',
                            showConfirmButton: false,
                            timer: 1500
                            });

                    }
                    else if(data == 2){
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Lượng giảm không hợp lệ',
                            showConfirmButton: false,
                            timer: 1500
                            });
                    }
                    else if(data == 3){
                        form_update_discount.submit();
                    }
                    else{
                        if(amount_discount_2 > Number(data) || amount_discount_2 < 1000 ){
                            Swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: 'Bạn chỉ giảm tối thiểu 1000vnđ và tối đa < '+formatNumber(data)+ 'vnđ',
                                showConfirmButton: false,
                                timer: 2000
                                });
                        }
                        else{
                            form_update_discount.submit();
                        }

                    }

                }
            });
    }

    // MODAL DELETE DISCOUNT
    $('.btn_show_modal_delete_discount').click(function(){
        var discount_id = $(this).attr('data-id');
        $('.id_delete_discount').val(discount_id);
    });
    $('.btn_confirm_delete_discount').click(function(){
        var form_delete = document.forms['form_delete_discount'];
        form_delete.submit();
    });


