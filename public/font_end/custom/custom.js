jQuery(document).ready(function() {
    jQuery('.carousel').slick({
      autoplay: true,
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: false,
      asNavFor: '.carousel-nav'
    });
    jQuery('.carousel-nav').slick({
      slidesToShow: 3,
      slidesToScroll: 1,
      asNavFor: '.carousel',
      dots: false,
      arrows: false,
      centerMode: true,
      focusOnSelect: true
    });
  });

  // Lorem Ipsum Generator by Luke Jackson
  // https://codepen.io/lukejacksonn/pen/rCdEb
  (function() {
    jQuery.fn.lorem = function(_length) {
      return this.each(function() {

        // Amount of words required
        var _length = _length || jQuery(this).data('lorem') || (Math.floor(Math.random() * 50) + 3);

        var charAtEndOfOut = function(char, step) {
          return out.indexOf(char, out.length - step - 1) !== -1;
        };

        var randomWord = function() {
          return words[Math.floor(Math.random() * (words.length - 1))];
        };

        var capitalize = function(word) {
          return word[0].toUpperCase() + word.slice(1);
        };

        // Dictionary of words
        var paragraph = "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt. ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.",
          words = paragraph.split(" "),
          word = "",
          out = capitalize(randomWord());

        for (var i = 1; i < _length; i = i + 1) {

          // Select random word from paragraph
          word = randomWord();
          out += " ";

          // Append to out, capitalize first letter if necessary
          out += (charAtEndOfOut('.', 1) || charAtEndOfOut('?', 1)) ?
            capitalize(word) :
            word.toLowerCase();
        }

        // Append full stop to the end of string, strip punctuation if necessary
        out = (charAtEndOfOut('.') || charAtEndOfOut(',') || charAtEndOfOut('?')) ?
          out.slice(0, -1) + "." :
          out + ".";

        jQuery(this).text(out);

      });
    };
    jQuery("[data-lorem]").lorem();
  })(jQuery);


// add to cart
$(document).ready(function(){
    function formatNumber (num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.")
    }
    function update_qty_when_change(product_id, _token){
        $.ajax({
            url: 'update_qty_when_change',
            method: 'POST',
            data: {
                _token: _token,
                product_id: product_id,
            },
            success: function (data) {
                $('.qty_cart_'+product_id).val(data);
            }
        });
    }
    function update_qty_when_change_many(product_id, _token){
        $.ajax({
            url: '../update_qty_when_change',
            method: 'POST',
            data: {
                _token: _token,
                product_id: product_id,
            },
            success: function (data) {
                $('.qty_cart_'+product_id).val(data);
            }
        });
    }
    function show_mini_cart_when_add(product_id, _token){
        $.ajax({
            url: 'show_mini_cart_when_add',
            method: 'POST',
            data: {
                product_id:product_id,
                _token: _token,
            },
            success: function (data) {
                $('.show_mini_cart_when_add').html(data);
            }
        });
    }
    function show_mini_cart_when_add_detail(product_id, _token){
        $.ajax({
            url: '../show_mini_cart_when_add',
            method: 'POST',
            data: {
                product_id:product_id,
                _token: _token,
            },
            success: function (data) {
                $('.show_mini_cart_when_add').html(data);
            }
        });
    }

    $('.add_cart_one').click(function(){
        var product_id = $(this).attr('data-id');
        var qty = $('.val_qty_'+product_id).val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: 'add_to_cart',
            method: 'POST',
            data: {
                product_id: product_id,
                qty: qty,
                _token: _token
            },
            success: function (data) {
                $(function(){
                    $.ajax({
                        url: 'load_quantity_cart',
                        method: 'POST',
                        data: {
                            _token: _token
                        },
                        success: function (data) {
                            $('.total_quantity_cart').html(data);
                        }
                    });
                });
                if(data == 1){
                    show_mini_cart_when_add(product_id, _token);
                    update_qty_when_change(product_id, _token);
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'đã thêm vào giỏ hàng',
                        showConfirmButton: false,
                        timer: 1000
                      });
                }
                else{
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'thêm giỏ hàng thất bại',
                        showConfirmButton: false,
                        timer: 1000
                      });
                }

            }
        });

    });
    $('.btn_buy_now').click(function(){
        var product_id = $(this).attr('data-id');
        var _token = $('input[name="_token"]').val();
        show_mini_cart_when_add(product_id, _token);
        update_qty_when_change(product_id, _token);
    });
    // $('.add_cart_many_detail').click(function(){
    //     var product_id = $(this).attr('data-id');
    //     var _token = $('input[name="_token"]').val();
    //     show_mini_cart_when_add_detail(product_id, _token);
    // });
    $('.add_cart_many').click(function(){
        var product_id = $(this).attr('data-id');
        var qty = $('.val_qty_'+product_id).val();
        var _token = $('input[name="_token"]').val();
        if(qty <= 0){
            $('.val_qty_'+product_id).val(1);
            qty = 1;
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Thêm vào giỏ hàng thất bại, số lượng tối thiểu là 1',
                showConfirmButton: false,
                timer: 1500
              });
        }
        else{
            $.ajax({
                url: '../add_to_cart',
                method: 'POST',
                data: {
                    product_id: product_id,
                    qty: qty,
                    _token: _token
                },
                success: function (data) {
                    $(function(){
                        $.ajax({
                            url: '../load_quantity_cart',
                            method: 'POST',
                            data: {
                                _token: _token
                            },
                            success: function (data) {
                                $('.total_quantity_cart').html(data);
                            }
                        });
                    });
                    if(data == 1){
                        show_mini_cart_when_add(product_id, _token);
                        update_qty_when_change_many(product_id, _token);
                        show_mini_cart_when_add_detail(product_id, _token);
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'đã thêm vào giỏ hàng',
                            showConfirmButton: false,
                            timer: 1000
                          });

                    }
                    else{
                        if(data == 0){
                            $('.val_qty_'+product_id).val(1);
                            Swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: 'thêm giỏ hàng thất bại, sản phầm không còn đủ số lượng mà bạn cần',
                                showConfirmButton: false,
                                timer: 2000
                            });
                        }
                        else{
                            $('.val_qty_'+product_id).val(data);
                            Swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: 'thêm giỏ hàng thất bại, bạn chỉ có thể mua thêm tối đa '+data+ ' sản phẩm',
                                showConfirmButton: false,
                                timer: 2000
                            });
                        }

                    }
                }
            });
        }
    });

    //btn-up quantity
    $('.btn_up_add_cart').click(function(){
        var quantity_up = $('.val_quantity').val();
        quantity_up++;
        $('.val_quantity').val(quantity_up);
    });
    //btn-down quantity
    $('.btn_down_add_cart').click(function(){
        var quantity_down = $('.val_quantity').val();
        if(quantity_down > 1){
            quantity_down--;
            $('.val_quantity').val(quantity_down);
        }
    });

    //delete item cart
    var modal_delete_item_cart = $('.modal_delete_item_cart');
    var btn_open_modal_delete_item_cart = $('.btn_open_modal_delete_item_cart');
    var close_modal = $('.close_modal');
    btn_open_modal_delete_item_cart.click(function () {
        modal_delete_item_cart.show();
    });
    close_modal.click(function () {
        modal_delete_item_cart.hide();
    });
    $(window).on('click', function (e) {
        if ($(e.target).is('.modal_mini_detail')) {
            modal_delete_item_cart.hide();
        }
    });
    $('.btn_open_modal_delete_item_cart').click(function(){
        var cart_id = $(this).attr('data-id');
        $('.delete_item_cart').val(cart_id);
    });
    $('.btn_confirm_delete_item_cart').click(function(){
        var form_delete = document.forms['form_delete_item_cart'];
        form_delete.submit();
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Xóa thành công',
            showConfirmButton: false,
            timer: 1500
            });
        setTimeout(
            function(){
                location.reload();
            }, 1600);
    });

    // modal mini cart
    var modal_mini_detail = $('.modal_mini_detail');
    var btn_open_modal = $('.btn_open_modal');
    var close_modal = $('.close_modal');
    btn_open_modal.click(function () {
        modal_mini_detail.show();
    });
    close_modal.click(function () {
        modal_mini_detail.hide();
    });
    $(window).on('click', function (e) {
        if ($(e.target).is('.modal_mini_detail')) {
            modal_mini_detail.hide();
        }
    });

});




