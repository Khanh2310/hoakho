@if (count($all_cart) > 0)
    <ul class="products">
        @foreach ($all_cart as $cart)
            <li>
                <div class="minicart-item">
                    @foreach ($all_product as $product)
                        @if ($cart->product_id == $product->product_id)
                            @php
                                $price_discount = App\Http\Controllers\HomeClientController::check_price_discount($product->product_id);
                            @endphp
                            <div class="thumb">
                                <a href="{{ URL::to('product_detail/' . $product->product_id) }}"><img
                                        src="{{ asset('public/upload/' . $product->product_image) }}"
                                        style="width: 90px; height: 90px;" alt="National Fresh"></a>
                            </div>
                            <div class="left-info">
                                <div class="product-title"><a
                                        href="{{ URL::to('product_detail/' . $product->product_id) }}"
                                        class="product-name">{{ $product->product_name }}</a></div>
                                            <div class="price">
                                                @if ($price_discount->percent_discount == 0)
                                                    <ins><span class="price-amount">
                                                        <span class="currencySymbol">
                                                            {{ number_format($price_discount->price_now, 0, ',', '.') }}đ
                                                        </span></span>
                                                    </ins>
                                                @else
                                                    <ins><span class="price-amount">
                                                        <span class="currencySymbol">
                                                            {{ number_format($price_discount->price_now, 0, ',', '.') }}đ
                                                        </span></span>
                                                    </ins>
                                                    <del><span class="price-amount">
                                                        <span class="currencySymbol">
                                                            {{ number_format($price_discount->price_old, 0, ',', '.') }}đ
                                                        </span></span>
                                                    </del>
                                                @endif
                                            </div>
                                    <div class="qty">
                                        <label for="cart[id123][qty]">Số lượng:</label>
                                        @foreach ($all_product as $product)
                                            @if ($cart->product_id == $product->product_id && $cart->customer_id == Session::get('customer_id'))
                                                <input type="number"
                                                    class="input-qty qty_cart_{{ $product->product_id }} qty_update_when_change_cart_{{ $cart->cart_id }}"
                                                    name="cart[id123][qty]" id="cart[id123][qty]" value="{{ $cart->quantity }}"
                                                    disabled>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>

                            </div>
                        @endif
                    @endforeach
            </li>

        @endforeach


    </ul>
    <p class="btn-control" style="display: flex; justify-content: flex-end">
        <a href="{{ URL::to('show_cart') }}" class="btn view-cart" style="border-radius: 2px">
            Xem Giỏ Hàng
        </a>
        {{-- <a href="#" class="btn">checkout</a> --}}
    </p>
@else
    <p class="minicart-empty">không có sản phẩm nào trong giỏ hàng</p>
@endif
