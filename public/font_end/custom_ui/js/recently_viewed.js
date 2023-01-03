$(document).ready(function(){
    $('.btn_recently_viewed').click(function (){
        var product_id = $(this).attr('data-id');
        var product_name = $('#recently_viewed_product_name_'+product_id).val();
        var product_price = $('#recently_viewed_product_price_'+product_id).val();
        var product_detail = $('#recently_viewed_product_detail_'+product_id).attr('href');
        var product_img = $('#recently_viewed_product_img_'+product_id).attr('src');

        var new_item = {
            'product_detail': product_detail,
            'product_id': product_id,
            'product_name': product_name,
            'product_price': product_price,
            'product_img': product_img,
        }
        if(localStorage.getItem('data')==null){
            localStorage.setItem('data', '[]');
        }
        var old_data = JSON.parse(localStorage.getItem('data'));
        var matches = $.grep(old_data, function(obj){
            return obj.product_id == product_id;
        });
        if(! matches.length > 0){
            old_data.push(new_item);
        }
        localStorage.setItem('data', JSON.stringify(old_data));
    });

    if(localStorage.getItem('data') != null){
        var data = JSON.parse(localStorage.getItem('data'));
        data.reverse();
        for(i=0; i<data.length; i++){
            var product_img = data[i].product_img;
            var product_name = data[i].product_name;
            var product_price = data[i].product_price;
            var product_detail = data[i].product_detail;
            $('.content_recently_viewed').append(
            '<li class="pr-item">'+
                '<div class="contain-product style-widget">'+
                    '<div class="product-thumb">'+
                        '<a href="'+product_detail+'" class="link-to-product" tabindex="0">'+
                            '<img src="'+product_img+'" alt="dd" style="width: 82px; height: 82px" class="product-thumnail">'+
                            '</a>'+
                    '</div>'+
                    '<div class="info">'+
                        '<h4 class="product-title">'+
                            '<a href="'+product_detail+'" class="pr-name" tabindex="0">'+product_name+'</a>'+
                        '</h4>'+
                        '<div class="price">'+
                            '<ins><span class="price-amount">'+product_price+'</span></ins>'+
                        '</div>'+
                    '</div>'+
                '</div>'+
            '</li>');
        }
        $('.content_recently_viewed').append('<div id="loadMore">Xem thêm</div><div id="loadLess">Thu gọn</div>');
    }
    else{
        $('.content_recently_viewed').append('<img src="public/upload/search_not_found.jpg" alt="" style="width: 100%; height: auto;">');
    }

    $('#myList li').slice(0, 2).show();
    if($('#myList li').length > 2){
        $('#loadMore').show();
    }

    var x = 2;

    $('#loadMore').click(function () {
        x = x + 2;
        $('#myList li').slice(0, x).slideDown();
        if($('#myList li').length == x || $('#myList li').length == (x - 1)){
            $('#loadMore').hide();
            $('#loadLess').show();
        }
    });

    $('#loadLess').click(function () {
        x = 2 - $('#myList li').length;
        $('#myList li').slice(x).slideUp();
        if($('#myList li').length > 2){
            $('#loadMore').show();
            $('#loadLess').hide();
        }
        x = 2;
    });
});
