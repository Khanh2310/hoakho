$('#btn_trace_product_many_date').click(function(){
    $('.content_trace_product_side_profile_date_single').addClass('dis-none');
    $('.content_trace_product_side_profile_date_many').removeClass('dis-none');
});
$('#btn_trace_product_single_date').click(function(){
    $('.content_trace_product_side_profile_date_single').removeClass('dis-none');
    $('.content_trace_product_side_profile_date_many').addClass('dis-none');
});
$('#btn_trace_product_fol_date').click(function(){
    let type_action = $('input[name="type_action_product_single"]:checked').val();
    let admin_id = $('.admin_id').val();
    let start_date = $('.choose_date_single').val();
    let product_id = $('#product_id_single_date').val();
    let _token = $('input[name="_token"]').val();
    if(start_date == ''){
        Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: 'Vui lòng điền ngày để truy vết',
            showConfirmButton: false,
            timer: 1500
        });
    }
    else{
        $.ajax({
            url: '../trace_product_side_profile_single_date',
            method: 'post',
            data: {
                _token: _token,
                type_action: type_action,
                start_date: start_date,
                product_id: product_id,
                admin_id: admin_id,
            },
            success: function (data) {
                $('#Modal_trace_product_side_profile').modal('hide');
                $('#content_trace_side_profile').html(data);
            }
        });
    }
});
$('#btn_trace_product_fol_date_many').click(function(){
    let type_action = $('input[name="type_action_product_many"]:checked').val();
    let admin_id = $('.admin_id').val();
    let start_date = $('.start_date').val();
    let end_date = $('.end_date').val();
    let product_id = $('#product_id_many_date').val();
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
            url: '../trace_product_side_profile_many_date',
            method: 'post',
            data: {
                _token: _token,
                type_action: type_action,
                start_date: start_date,
                end_date: end_date,
                product_id: product_id,
                admin_id: admin_id,
            },
            success: function (data) {
                $('#Modal_trace_product_side_profile').modal('hide');
                $('#content_trace_side_profile').html(data);
            }
        });
    }
});

// trace cate
$('#btn_trace_cate_many_date').click(function(){
    $('.content_trace_cate_side_profile_date_single').addClass('dis-none');
    $('.content_trace_cate_side_profile_date_many').removeClass('dis-none');
});
$('#btn_trace_cate_single_date').click(function(){
    $('.content_trace_cate_side_profile_date_single').removeClass('dis-none');
    $('.content_trace_cate_side_profile_date_many').addClass('dis-none');
});
$('#btn_trace_cate_fol_date').click(function(){
    let type_action = $('input[name="type_action_cate_single"]:checked').val();
    let admin_id = $('.admin_id').val();
    let start_date = $('.choose_cate_date_single').val();
    let cate_id = $('#cate_id_single_date').val();
    let _token = $('input[name="_token"]').val();
    if(start_date == ''){
        Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: 'Vui lòng điền ngày để truy vết',
            showConfirmButton: false,
            timer: 1500
        });
    }
    else{
        $.ajax({
            url: '../trace_cate_side_profile_single_date',
            method: 'post',
            data: {
                _token: _token,
                type_action: type_action,
                start_date: start_date,
                cate_id: cate_id,
                admin_id: admin_id,
            },
            success: function (data) {
                $('#Modal_trace_cate_side_profile').modal('hide');
                $('#content_trace_side_profile').html(data);
            }
        });
    }
});
$('#btn_trace_cate_fol_date_many').click(function(){
    let type_action = $('input[name="type_action_cate_many"]:checked').val();
    let admin_id = $('.admin_id').val();
    let start_date = $('.start_date_cate').val();
    let end_date = $('.end_date_cate').val();
    let cate_id = $('#cate_id_many_date').val();
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
            url: '../trace_cate_side_profile_many_date',
            method: 'post',
            data: {
                _token: _token,
                type_action: type_action,
                start_date: start_date,
                end_date: end_date,
                cate_id: cate_id,
                admin_id: admin_id,
            },
            success: function (data) {
                $('#Modal_trace_cate_side_profile').modal('hide');
                $('#content_trace_side_profile').html(data);
            }
        });
    }
});
// trace price product
$('#btn_trace_price_product_many_date').click(function(){
    $('.content_trace_price_product_side_profile_date_single').addClass('dis-none');
    $('.content_trace_price_product_side_profile_date_many').removeClass('dis-none');
});
$('#btn_trace_price_product_single_date').click(function(){
    $('.content_trace_price_product_side_profile_date_single').removeClass('dis-none');
    $('.content_trace_price_product_side_profile_date_many').addClass('dis-none');
});
$('#btn_trace_price_product_fol_date').click(function(){
    let type_action = $('input[name="type_action_price_single"]:checked').val();
    let admin_id = $('.admin_id').val();
    let start_date = $('.choose_price_product_date_single').val();
    let product_id = $('#price_product_id_single_date').val();
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
            url: '../trace_price_product_side_profile_single_date',
            method: 'post',
            data: {
                _token: _token,
                type_action: type_action,
                start_date: start_date,
                product_id: product_id,
                admin_id: admin_id,
            },
            success: function (data) {
                $('#Modal_trace_product_price_side_profile').modal('hide');
                $('#content_trace_side_profile').html(data);
            }
        });
    }
});
$('#btn_trace_price_product_fol_date_many').click(function(){
    let type_action = $('input[name="type_action_price_many"]:checked').val();
    let admin_id = $('.admin_id').val();
    let start_date = $('.start_date_price_product').val();
    let end_date = $('.end_date_price_product').val();
    let product_id = $('#price_product_id_many_date').val();
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
            url: '../trace_price_product_side_profile_many_date',
            method: 'post',
            data: {
                _token: _token,
                type_action: type_action,
                start_date: start_date,
                end_date: end_date,
                product_id: product_id,
                admin_id: admin_id,
            },
            success: function (data) {
                $('#Modal_trace_product_price_side_profile').modal('hide');
                $('#content_trace_side_profile').html(data);
            }
        });
    }
});

// trace admin
$('#btn_trace_admin_many_date').click(function(){
    $('.content_trace_admin_side_profile_date_single').addClass('dis-none');
    $('.content_trace_admin_side_profile_date_many').removeClass('dis-none');
});
$('#btn_trace_admin_single_date').click(function(){
    $('.content_trace_admin_side_profile_date_single').removeClass('dis-none');
    $('.content_trace_admin_side_profile_date_many').addClass('dis-none');
});
$('#btn_trace_admin_fol_date').click(function(){
    let type_action = $('input[name="type_action_admin_single"]:checked').val();
    let admin_id = $('.admin_id').val();
    let start_date = $('.choose_date_admin_single').val();
    let admin_id_single_date = $('#admin_id_single_date').val();
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
            url: '../trace_admin_side_profile_single_date',
            method: 'post',
            data: {
                _token: _token,
                type_action: type_action,
                start_date: start_date,
                admin_id_single_date: admin_id_single_date,
                admin_id: admin_id,
            },
            success: function (data) {
                $('#Modal_trace_admin_side_profile').modal('hide');
                $('#content_trace_side_profile').html(data);
            }
        });
    }
});
$('#btn_trace_admin_fol_date_many').click(function(){
    let type_action = $('input[name="type_action_admin_many"]:checked').val();
    let admin_id = $('.admin_id').val();
    let admin_id_many_date = $('#admin_id_many_date').val();
    let start_date = $('.start_date_admin').val();
    let end_date = $('.end_date_admin').val();
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
            url: '../trace_admin_side_profile_many_date',
            method: 'post',
            data: {
                _token: _token,
                type_action: type_action,
                start_date: start_date,
                end_date: end_date,
                admin_id_many_date: admin_id_many_date,
                admin_id: admin_id,
            },
            success: function (data) {
                $('#Modal_trace_admin_side_profile').modal('hide');
                $('#content_trace_side_profile').html(data);
            }
        });
    }
});

// trace product image
$('#btn_trace_product_image_many_date').click(function(){
    $('.content_trace_product_image_side_profile_date_single').addClass('dis-none');
    $('.content_trace_product_image_side_profile_date_many').removeClass('dis-none');
});
$('#btn_trace_product_image_single_date').click(function(){
    $('.content_trace_product_image_side_profile_date_single').removeClass('dis-none');
    $('.content_trace_product_image_side_profile_date_many').addClass('dis-none');
});
$('#btn_trace_product_image_fol_date').click(function(){
    let admin_id = $('.admin_id').val();
    let start_date = $('.choose_date_product_image_single').val();
    let product_id = $('#image_product_id_single_date').val();
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
            url: '../trace_product_image_side_profile_single_date',
            method: 'post',
            data: {
                _token: _token,
                start_date: start_date,
                product_id: product_id,
                admin_id: admin_id,
            },
            success: function (data) {
                $('#Modal_trace_product_image_side_profile').modal('hide');
                $('#content_trace_side_profile').html(data);
            }
        });
    }
});
$('#btn_trace_product_price_fol_date_many').click(function(){
    let admin_id = $('.admin_id').val();
    let start_date = $('.start_date_product_image').val();
    let end_date = $('.end_date_product_image').val();
    let product_id = $('#image_product_id_many_date').val();
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
            url: '../trace_product_image_side_profile_many_date',
            method: 'post',
            data: {
                _token: _token,
                start_date: start_date,
                end_date: end_date,
                product_id: product_id,
                admin_id: admin_id,
            },
            success: function (data) {
                $('#Modal_trace_product_image_side_profile').modal('hide');
                $('#content_trace_side_profile').html(data);
            }
        });
    }
});

// trace storage
$('#btn_trace_storage_many_date').click(function(){
    $('.content_trace_storage_side_profile_date_single').addClass('dis-none');
    $('.content_trace_storage_side_profile_date_many').removeClass('dis-none');
});
$('#btn_trace_storage_single_date').click(function(){
    $('.content_trace_storage_side_profile_date_single').removeClass('dis-none');
    $('.content_trace_storage_side_profile_date_many').addClass('dis-none');
});
$('#btn_trace_storage_fol_date').click(function(){
    let type_action = $('input[name="type_action_storage_single"]:checked').val();
    let admin_id = $('.admin_id').val();
    let start_date = $('.choose_date_storage_single').val();
    let storage_id = $('#storage_id_single').val();
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
            url: '../trace_storage_side_profile_single_date',
            method: 'post',
            data: {
                _token: _token,
                type_action: type_action,
                start_date: start_date,
                storage_id: storage_id,
                admin_id: admin_id,
            },
            success: function (data) {
                $('#Modal_trace_storage_side_profile').modal('hide');
                $('#content_trace_side_profile').html(data);
            }
        });
    }
});
$('#btn_trace_storage_fol_date_many').click(function(){
    let type_action = $('input[name="type_action_storage_many"]:checked').val();
    let admin_id = $('.admin_id').val();
    let storage_id = $('#storage_id_many').val();
    let start_date = $('.start_date_storage_many').val();
    let end_date = $('.end_date_storage_many').val();
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
            url: '../trace_storage_side_profile_many_date',
            method: 'post',
            data: {
                _token: _token,
                type_action: type_action,
                start_date: start_date,
                end_date: end_date,
                storage_id: storage_id,
                admin_id: admin_id,
            },
            success: function (data) {
                $('#Modal_trace_storage_side_profile').modal('hide');
                $('#content_trace_side_profile').html(data);
            }
        });
    }
});

// trace storage product
$('#btn_trace_storage_product_many_date').click(function(){
    $('.content_trace_storage_product_side_profile_date_single').addClass('dis-none');
    $('.content_trace_storage_product_side_profile_date_many').removeClass('dis-none');
});
$('#btn_trace_storage_product_single_date').click(function(){
    $('.content_trace_storage_product_side_profile_date_single').removeClass('dis-none');
    $('.content_trace_storage_product_side_profile_date_many').addClass('dis-none');
});
$('#btn_trace_storage_product_fol_date').click(function(){
    let type_action = $('input[name="type_action_storage_product_single"]:checked').val();
    let admin_id = $('.admin_id').val();
    let start_date = $('.choose_date_storage_product_single').val();
    let product_id = $('#storage_product_id_single').val();
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
            url: '../trace_storage_product_side_profile_single_date',
            method: 'post',
            data: {
                _token: _token,
                type_action: type_action,
                start_date: start_date,
                product_id: product_id,
                admin_id: admin_id,
            },
            success: function (data) {
                $('#Modal_trace_storage_product_side_profile').modal('hide');
                $('#content_trace_side_profile').html(data);
            }
        });
    }
});
$('#btn_trace_storage_product_fol_date_many').click(function(){
    let type_action = $('input[name="type_action_storage_product_many"]:checked').val();
    let admin_id = $('.admin_id').val();
    let product_id = $('#storage_product_id_many').val();
    let start_date = $('.start_date_storage_product_many').val();
    let end_date = $('.end_date_storage_product_many').val();
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
            url: '../trace_storage_product_side_profile_many_date',
            method: 'post',
            data: {
                _token: _token,
                type_action: type_action,
                start_date: start_date,
                end_date: end_date,
                product_id: product_id,
                admin_id: admin_id,
            },
            success: function (data) {
                $('#Modal_trace_storage_product_side_profile').modal('hide');
                $('#content_trace_side_profile').html(data);
            }
        });
    }
});
