$(document).ready(function(){
    // accept comment
     $('.btn_open_modal_accep_comment').click(function(){
        var comment_id = $(this).attr('data-id');
        $('.id_accep_comment').val(comment_id);
    });
    $('.btn_confirm_accep_comment').click(function(){
        var form_accep = document.forms['form_accep_comment'];
        form_accep.submit();
    });

    // unaccept comment
    $('.btn_open_modal_unaccep_comment').click(function(){
        var comment_id = $(this).attr('data-id');
        $('.id_unaccep_comment').val(comment_id);
    });
    $('.btn_confirm_unaccep_comment').click(function(){
        var form_unaccep = document.forms['form_unaccep_comment'];
        form_unaccep.submit();
    });
})
