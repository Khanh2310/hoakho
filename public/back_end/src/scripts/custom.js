
    $('#file_upload').change(function(){
        $('#image_upload').addClass('op-1');
        $('#content_image_upload').addClass('op-1');
    });
    $('.confirm').click(function(){
        location.reload();
    });

    ////////////////// DELETE ////////////////////
    // Modal delete forever
    $('.btn_delete_forever').click(function(){
        var admin_id = $(this).attr('data-id');
        $('.admin_id_delete_forever').val(admin_id);
    });
    $('.btn_confirm_delete_forever').click(function(){
        var form_delete = document.forms['form_delete_forever'];
        form_delete.submit();
    });

    //soft delete
    $('.soft_delete_admin_class').click(function(){
            var admin_id = $(this).attr('data-id');
            $('.id_delete_admin').val(admin_id);
    });
    $('.btn_delete_soft').click(function(){
        var form_delete = document.forms['form_soft_delete'];
        form_delete.submit();
    });

    //soft delete product
    $('.soft_delete_product_class').click(function(){
            var product_id = $(this).attr('data-id');
            $('.id_delete_product').val(product_id);
    });
    $('.btn_delete_soft_product').click(function(){
        var form_delete = document.forms['form_soft_delete_product'];
        form_delete.submit();
    });
    //delete forever product
    $('.btn_delete_forever_product').click(function(){
        var product_id = $(this).attr('data-id');
        $('.product_id_delete_forever').val(product_id);
    });
    $('.btn_confirm_delete_forever_product').click(function(){
        var form_delete = document.forms['form_delete_forever_product'];
        form_delete.submit();
    });
    //soft delete image product
    $('.soft_delete_image_product_class').click(function(){
        var image_id = $(this).attr('data-id');
        $('.id_delete_image_product').val(image_id);
    });
    $('.btn_delete_soft_image_product').click(function(){
        var form_delete = document.forms['form_soft_delete_image_product'];
        form_delete.submit();
    });
    //delete forever product image
    $('.forever_delete_image_product_class').click(function(){
        var image_id = $(this).attr('data-id');
        $('.id_delete_forever_image_product').val(image_id);
    });
    $('.btn_confirm_delete_forever_product').click(function(){
        var form_delete = document.forms['form_delete_forever_product'];
        form_delete.submit();
    });

    // soft delete category
    $('.soft_delete_category_class').click(function(){
            var cate_id = $(this).attr('data-id');
            $('.id_delete_category').val(cate_id);
    });
    $('.btn_delete_forever').click(function(){
        var cate_id = $(this).attr('data-id');
        $('.category_id_delete_forever').val(cate_id);
    });

    // soft delete storage
    $('.soft_delete_storage_class').click(function(){
        var storage_id = $(this).attr('data-id');
        $('.id_delete_storage').val(storage_id);
    });
    $('.btn_delete_forever').click(function(){
        var storage_id = $(this).attr('data-id');
        $('.storage_id_delete_forever').val(storage_id);
    });

    // soft delete storage product
    $('.soft_delete_storage_product_class').click(function(){
        var storage_product_id = $(this).attr('data-id');
        $('.id_delete_storage_product').val(storage_product_id);
    });
    $('.btn_delete_forever').click(function(){
        var storage_product_id = $(this).attr('data-id');
        $('.storage_product_id_delete_forever').val(storage_product_id);
    });

    // time out alert
    $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
        $("#success-alert").slideUp(500);
    });

    //search category
    $('#find_category').keyup(function(){
        var value_find = $('#find_category').val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: 'find_category',
            method: 'get',
            data: {
                value_find: value_find,
                _token: _token
            },
            success: function (data) {
                $('.content_find_category').html(data);
            }
        });
    });

    //search storage
    $('#find_storage').keyup(function(){
        var value_find = $('#find_storage').val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: 'find_storage',
            method: 'get',
            data: {
                value_find: value_find,
                _token: _token
            },
            success: function (data) {
                $('.content_find_storage').html(data);
            }
        });
    });

    $('#find_storage').keydown(function(){
        var value_find = $('#find_storage').val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: 'find_storage',
            method: 'get',
            data: {
                value_find: value_find,
                _token: _token
            },
            success: function (data) {
                $('.content_find_storage').html(data);
            }
        });
    });

    //search storage product
    $('#find_storage_product').keyup(function(){
        var value_find = $('#find_storage_product').val();
        var _token = $('input[name="_token"]').val();
        var value_storage_id = $('#storage_id').val();
        $.ajax({
            url: '../find_storage_product',
            method: 'post',
            data: {
                value_find: value_find,
                _token: _token,
                value_storage_id: value_storage_id
            },
            success: function (data) {
                $('.content_find_storage_product').html(data);
            }
        });
    });
    // change live profile
    $('.change_name').keyup(function(){
        $('.following_name').text($('.change_name').val());
    });
    $('.change_birthday').keyup(function(){
        $('.following_birthday').text($('.change_birthday').val());
    });
    $('.change_gender').change(function(){
        var val_gender = $('#change_gender :selected').text();
        $('.following_gender').text(val_gender);
    });
    $('.change_email').keyup(function(){
        $('.following_email').text($('.change_email').val());
    });
    $('.change_phone').keyup(function(){
        $('.following_phone').text($('.change_phone').val());
    });
    $('#city_update_profile').change(function(){
        var city = $('#city_update_profile :selected').text();
        $('.following_city').text(city+", ");
    });
    $('#ward_update_profile_admin').change(function(){
        var ward = $('#ward_update_profile_admin :selected').text();
        $('.following_ward').text(ward);
    });
    $('#district_update_profile_admin').change(function(){
        var district = $('#district_update_profile_admin :selected').text();
        $('.following_district').text(district);
    });

    //custom file input add image gallery product
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
    //update price product
    $('.update_price_product').click(function(){
        var price = $(this).attr('data-id');
        $('.val_price_product').val(price);
    });
    $('.btn_update_price_product').click(function(){
        var form_delete = document.forms['update_price_product'];
        form_delete.submit();
    });

      //update storage
      $('.update_storage').click(function(){
        var storage_id = $(this).attr('data-id');
        var _token = $('input[name="_token"]').val();
         $('.val_storage').val(storage_id);
        $.ajax({
            url: 'storage_id_update',
            method: 'post',
            data: {
                _token: _token,
                storage_id: storage_id
            },
            success: function (data) {
                $('.name_storage_update').val(data);

            }
        });
    });
    $('.btn_update_storage').click(function(){
        var form_delete = document.forms['update_storage'];
        form_delete.submit();
    });

    //add storage
    $('.btn_add_storage').click(function(){
        var form_delete = document.forms['add_storage'];
        form_delete.submit();
    });


    //keep active when load page tab
    $(function() {
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        localStorage.setItem('lastTab', $(this).attr('href'));
        });
        var lastTab = localStorage.getItem('lastTab');

        if (lastTab) {
        $('[href="' + lastTab + '"]').tab('show');
        }
    });
    //find table fiter boostrap
    $(document).ready(function(){
        $("#val_find_recycle").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#table_find_recycle tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });





