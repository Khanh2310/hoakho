$(document).ready(function(){
    // DELETE SLIDER
    $('.delete_slider').click(function(){
        var slider_id = $(this).attr('data-id');
        $('.slider_id').val(slider_id);
    });
    $('.btn_delete_slider').click(function(){
        var form_delete = document.forms['form_delete_slider'];
        form_delete.submit();
    });
});