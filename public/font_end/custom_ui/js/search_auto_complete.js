// $(document).ready(function(){
//     var val_search_auto_complte = $('.input_search_auto_complete').val();
//     $('.input_search_auto_complete').focus(function(){
//         $('.content_auto_complete_search').removeClass('dis_none');
//     });
//     //
//     $('.input_search_auto_complete').keyup(function(){
//         val_search_auto_complte = $('.input_search_auto_complete').val();
//         if(val_search_auto_complte != ""){
//             $('.text_question').addClass('dis_none');
//             $('.content_search').removeClass('dis_none');
//             $('.txt_val_search').html(val_search_auto_complte);

//             // ajax val
//             var _token = $('input[name="_token"]').val();
//             $.ajax({
//                 url: 'ajax_search_auto_complete',
//                 method: 'POST',
//                 data: {
//                     _token: _token,
//                     val_search_auto_complte: val_search_auto_complte,
//                 },
//                 success: function (data) {
//                     $('.content_item').html(data);
//                 }
//             });
//         }
//         else{
//             $('.text_question').removeClass('dis_none');
//             $('.content_search').addClass('dis_none');
//         }
//     });
//     $('.input_search_auto_complete').focusout(function(){
//         if(val_search_auto_complte == ""){
//             $('.content_auto_complete_search').addClass('dis_none');
//         }
//     });

// });
