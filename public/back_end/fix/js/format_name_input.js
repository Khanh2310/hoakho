function titleCase(str) {
    var splitStr = str.toLowerCase().split(' ');
    for (var i = 0; i < splitStr.length; i++) {
        splitStr[i] = splitStr[i].charAt(0).toUpperCase() + splitStr[i].substring(1);
    }
    return splitStr.join(' ')
        .replace(/[&/\#,@!`~+()$~.;[\]'":*?<>{}^ ]/g, " ")
        .replace(/ +(?= )/g,'');
 }


 $('.format_name_input').blur(function(){
    var name = $('.format_name_input').val();
    $('.format_name_input').val(titleCase(name));
 });
 $('.check_format_name_input').blur(function(){
    var name = $('.check_format_name_input').val();
    $('.check_format_name_input').val(titleCase(name));
    if (/\d/.test(name)) {
        Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: 'Tên không hợp lệ',
            showConfirmButton: false,
            timer: 1500
        });
        $('.check_format_name_input').focus();
    }
 });
 $('.check_format_name_input_update').blur(function(){
    var name = $('.check_format_name_input_update').val();
    $('.check_format_name_input_update').val(titleCase(name));
    if (/\d/.test(name)) {
        Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: 'Tên không hợp lệ',
            showConfirmButton: false,
            timer: 1500
        });
        $('.check_format_name_input_update').focus();
    }
 });
