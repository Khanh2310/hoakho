@php
$total_temporary_price = 0;
$total_qty = 0;
@endphp
@foreach ($arrCart_id as $cart_id)
    @foreach ($all_cart as $cart)
        @if ($cart_id == $cart->cart_id)
            @php
                $price_prod;
                $qty_prod;
                $price_discount = App\Http\Controllers\HomeClientController::check_price_discount($cart->product_id);
            @endphp
            @foreach ($all_product as $product)
                @if ($product->product_id == $cart->product_id)
                    <div class="content__res-check-out">
                        <div class="res-check-out__image">
                            <img src="{{ asset('public/upload/' . $product->product_image) }}" alt="">
                        </div>
                        <div class="res-check-out__info">
                            <label class="res-check-out__info-name res_text">{{ $product->product_name }}</label>
                            <div class="res-check-out__info--price-quantity">
                                <div class="info-price">
                                    {{-- <input type="checkbox" name="cart_id[]" value="{{ $cart->cart_id }}" style="opacity: 0" checked> --}}

                                    {{ number_format($price_discount->price_now, 0, ',', '.') }}₫
                                    @php
                                        $price_prod = $price_discount->price_now;
                                    @endphp
                                </div>

                                <div class="info-quantity">
                                    x{{ $cart->quantity }}
                                    <input type="hidden" value="{{ $cart->quantity }}" class="qty_prod_voucher_{{ $product->product_id }}">
                                    @php
                                        $qty_prod = $cart->quantity;
                                        $total_qty += $cart->quantity;
                                    @endphp
                                </div>

                                @php
                                    $total_temporary_price += $price_prod * $qty_prod;
                                @endphp
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif
    @endforeach
@endforeach
