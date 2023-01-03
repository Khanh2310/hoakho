$(document).ready(function(){
    $('#file_upload').change(function(){
        $('#image_upload').addClass('op-1');
        $('#content_image_upload').addClass('op-1');
    });
    $('.confirm').click(function(){
        location.reload();
    });

    //add count
    $('.add_address_account').click(function(){
        var id = $(this).attr('data-id');
        $('.add_address_account').val(id);
    });
});


// Get the modal
var modal_add_address = document.getElementById("modal_add_address");

// Get the button that opens the modal
var btn_add_address = document.getElementById("btn-open-model-add_address");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal
btn_add_address.onclick = function() {
  modal_add_address.style.display = "block";
}

var btn_close = document.getElementById("close");
btn_close.onclick = function(){
    modal_add_address.style.display="none";
}

var btn_close_modal = document.getElementById("btn_close_modal");
btn_close_modal.onclick = function(){
    modal_add_address.style.display="none";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal_add_address.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal_add_address) {
    modal_add_address.style.display = "none";
  }
}




//MODAL DELETE ADDRESS
// Get the modal
var modal_delte_address = document.getElementById("modal_delete_address");

$(document).ready(function(){
    //delete item address
    $('.get_trans_id').click(function(){
        var trans_id = $(this).attr('data-id');




        // DELETE ADDRESS
        // Get the button that opens the modal
        var open_modal = "btn-open-model-delete_address_"+trans_id;
        var btn_delete_address = document.getElementById(open_modal);

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close_delete_address")[0];
        
        var btn_close_delete = document.getElementById("close_delete_address");

        btn_close_delete.onclick = function(){
            modal_delete_address.style.display="none";
        }

        var close_modal_delete_address = document.getElementById("close_modal_delete_address");

        close_modal_delete_address.onclick = function(){
            modal_delete_address.style.display="none";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
        modal_delete_address.style.display = "none";
        }

        // When the user clicks the button, open the modal
        btn_delete_address.onclick = function() {
        modal_delete_address.style.display = "block";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal_delte_address) {
                modal_delete_address.style.display = "none";
            }
        }
    });
});

$(document).ready(function(){
    //delete item address
    $('.get_trans_id_update_address').click(function(){
        var trans_id = $(this).attr('data-id');




        // UPDATE ADDRESS
        // Get the button that opens the modal
        var open_modal_update = "btn-open-model-update_address_"+trans_id;
        var btn_update_address = document.getElementById(open_modal_update);

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close_update_address")[0];
        
        var btn_close_update = document.getElementById("close_update_address");

        btn_close_update.onclick = function(){
            modal_update_address.style.display="none";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
        modal_update_address.style.display = "none";
        }

        // When the user clicks the button, open the modal
        btn_update_address.onclick = function() {
        modal_update_address.style.display = "block";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal_update_address) {
                modal_update_address.style.display = "none";
            }
        }
    });
});