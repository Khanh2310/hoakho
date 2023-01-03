@php
    $price_discount = App\Http\Controllers\HomeClientController::check_price_discount($product->product_id);
    $info_rating_saled = App\Http\Controllers\HomeClientController::info_rating_saled($product->product_id);
@endphp
<style>
    .count_saled{
        border-left: 1px solid green;
        height: 24px;
        padding-left: 10px;
        margin-left: 10px;
    }
</style>
<div class="content-image">
    <img src="{{ asset('public/upload/'.$product->product_image) }}" alt="" style="width: 361px; height: 361px;">
</div>
<div class="content_info_product">
    <h4 class="title">
        <div class="product_id"></div>
        <a href="#" class="pr-name name_product_mini">{{ $product->product_name }}</a>
    </h4>
    <div class="rating" style="display: flex;">
        <p class="star-rating" style="align-self: flex-start">
            <span class="width-80percent" style="width: {{ $info_rating_saled->avg_rating *20 }}%"></span>
        </p>
        <span class="count_rating"> ({{ $info_rating_saled->count_all_rating }} Đánh Giá)</span>
        <span class="count_saled">{{ $info_rating_saled->count_product_saled }} Đã Bán</span>
    </div>
    <div class="price price-contain">
        @if ($price_discount->percent_discount == 0)
            <ins>
                <span class="price-amount">
                    <span class="currencySymbol price_prod">
                        {{ number_format($price_discount->price_now, 0, ',', '.') }}đ
                    </span>
                </span>
            </ins>
        @else
            <ins>
                <span class="price-amount">
                    <span class="currencySymbol price_prod">
                        {{ number_format($price_discount->price_now, 0, ',', '.') }}đ
                    </span>
                </span>
            </ins>
            <del>
                <span class="price-amount">
                    <span class="currencySymbol">
                        {{ number_format($price_discount->price_old, 0, ',', '.') }}đ
                    </span>
                </span>
            </del>
            <ins>
                <span class="price-amount">
                    <span class="badge custom_badge">GIẢM {{ $price_discount->percent_discount }}%</span>
                </span>
            </ins>

        @endif

    </div>
    <div class="sort_desc_product" style="font-size: 15px;">{!! $product->product_sort_desc !!}</div>
    <div class="from-cart">
        <div class="qty-input">
            <input class="qty_prod qty_mini_detail_{{ $product->product_id }}" type="number" name="qty_mini_detail" value="1" data-max_value="100" data-min_value="1" data-step="1">
            <a href="#" class="qty-btn btn-up"><i class="fa fa-caret-up up" aria-hidden="true"></i></a>
            <a href="#" class="qty-btn btn-down"><i class="fa fa-caret-down down" aria-hidden="true"></i></a>
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        </div>
        <div class="buttons">
            @if (Session::get('customer_id'))
                <button class="btn add-to-cart-btn btn-bold btn_add_cart btn_add_cart_mini_detail" data-id="{{ $product->product_id }}">Thêm Vào Giỏ Hàng</button>
            @else
                <a href="{{ URL::to('login_client') }}"class="btn add-to-cart-btn btn-bold">Thêm Vào Giỏ Hàng</a>
            @endif

        </div>
    </div>
    <div class="product-meta">
        <div class="product-atts">
            <div class="product-atts-item show_category">
                <b class="meta-title" style="font-size: 15px;">Danh mục sản phẩm:</b>
                <label for="" style="font-size: 15px;">{{ $cate->cate_name }}</label>
            </div>
            <div class="show_qty_storage">
                <b class="meta-title" style="font-size: 15px;">Sản Phẩm Có Sẵn: </b>
                <label for="" style="font-size: 15px;">{{ $product_storage->total_quantity_product }}</label>
            </div>
        </div>
        <div class="biolife-social inline add-title">
            <span class="fr-title">Chia sẻ:</span>
            <ul class="socials">
                <li><a href="#" title="twitter" class="socail-btn"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                <li><a href="#" title="facebook" class="socail-btn"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                <li><a href="#" title="pinterest" class="socail-btn"><i class="fa fa-pinterest" aria-hidden="true"></i></a></li>
                <li><a href="#" title="youtube" class="socail-btn"><i class="fa fa-youtube" aria-hidden="true"></i></a></li>
                <li><a href="#" title="instagram" class="socail-btn"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
            </ul>
        </div>
    </div>
</div>
<script>
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
    $(document).ready(function(){
        $('.btn_add_cart_mini_detail').click(function(){
            var product_id = $(this).attr('data-id');
            var qty = $('.qty_mini_detail_'+product_id).val();
            var _token = $('input[name="_token"]').val();
            if(qty <= 0){
                $('.qty_mini_detail_'+product_id).val(1);
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
                            $('.modal_mini_detail').hide();
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
                                $('.qty_mini_detail_'+product_id).val(1);
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'error',
                                    title: 'thêm giỏ hàng thất bại, sản phầm không còn đủ số lượng mà bạn cần',
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                            }
                            else{
                                $('.qty_mini_detail_'+product_id).val(data);
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
    });
</script>
