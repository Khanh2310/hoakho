{{-- <link rel="stylesheet" href="{{ asset('public/font_end/custom/mini_detail_product.css') }}"> --}}
@if (count($result_sort) > 0)
    {{-- check type filter --}}
    @if (isset($type_filter))
        <input type="hidden" class="type_filter" value="{{ $type_filter }}">
        <input type="hidden" class="level_filter" value="{{ $level_filter }}">
        @if (isset($level_filter_price_start))
            <input type="hidden" class="level_filter_price_start" value="{{ $level_filter_price_start }}">
            <input type="hidden" class="level_filter_price_end" value="{{ $level_filter_price_end }}">
        @else
            <input type="hidden" class="level_filter_price_start" value="">
            <input type="hidden" class="level_filter_price_end" value="">
        @endif
    @else
        <input type="hidden" class="type_filter" value="">
        <input type="hidden" class="level_filter" value="">
    @endif
    {{--  --}}
    <ul class="products-list" style="list-style-type: none;">
        @foreach ($result_sort as $product)
            @php
                $price_discount = App\Http\Controllers\HomeClientController::check_price_discount($product->product_id);
                $info_rating_saled = App\Http\Controllers\HomeClientController::info_rating_saled($product->product_id);
                $check_already_wish = App\Http\Controllers\WishListController::checkProductWishLish($product->product_id);
            @endphp
            <div class="laptop">
                <li class="product-item col-lg-4 col-md-4 col-sm-4 col-xs-6">
                    <div class="contain-product layout-default content_product">
                        <div class="product-thumb">
                            <form>
                                @csrf
                                <input type="hidden" value="{{ $product->product_name }}" id="recently_viewed_product_name_{{ $product->product_id }}">
                                <input type="hidden" value="{{ number_format($price_discount->price_now, 0, ',', '.') }}₫" id="recently_viewed_product_price_{{ $product->product_id }}">
                            </form>
                            <a href="{{ URL::to('product_detail_slug/' . $product->slug) }}" class="link-to-product btn_recently_viewed" data-id="{{ $product->product_id }}" id="recently_viewed_product_detail_{{ $product->product_id }}">
                                <img src="{{ asset('public/upload/' . $product->product_image) }}" alt="dd" style="width: 270px; height: 270px" class="product-thumnail" id="recently_viewed_product_img_{{ $product->product_id }}">
                            </a>
                            <span href="#" class="lookup get_val_quickview btn_call_quickview_detail btn_open_modal" data-id="{{ $product->product_id }}"><i class="biolife-icon icon-search"></i></span>
                        </div>
                        <div class="info">
                            <h4 class="product-title">
                                <a href="{{ URL::to('product_detail_slug/' . $product->slug) }}" class="pr-name name_product btn_recently_viewed" data-id="{{ $product->product_id }}">{{ $product->product_name }}</a>
                            </h4>
                            <div class="price">
                                @if ($price_discount->percent_discount == 0)
                                    <ins><span class="price-amount"><span class="currencySymbol">{{ number_format($price_discount->price_now, 0, ',', '.') }}₫</span></ins>
                                @else
                                    <ins><span class="price-amount"><span class="currencySymbol">{{ number_format($price_discount->price_now, 0, ',', '.') }}₫</span></ins>
                                    <del><span class="price-amount"><span class="currencySymbol">{{ number_format($price_discount->price_old, 0, ',', '.') }}₫</span></del>
                                @endif
                            </div>
                            <div class="content_qty_rating">
                                {{-- <p class="shipping-day">3-Day Shipping</p>
                                                                        <p class="for-today">Pree Pickup Today</p> --}}
                                <div class="rating" style="display: flex;">
                                    <p class="star-rating" style="align-self: flex-start">
                                        <span class="width-80percent" style="width:{{ $info_rating_saled->avg_rating * 20 }}%"></span>
                                    </p>
                                </div>
                                <div class="availeble_product">Đã bán: {{ $info_rating_saled->count_product_saled }}</div>
                            </div>
                            <div class="slide-down-box">
                                {{-- <p class="message">All products are carefully selected to ensure food safety.</p> --}}
                                <div class="buttons">
                                    {{-- wish list --}}
                                    @if (Session::get('customer_id'))
                                        <a class="btn wishlist-btn btn_add_wish_lish" style="cursor: pointer;" data-id="{{ $product->product_id }}">
                                            @if ($check_already_wish->check_already == 1)
                                                <i class="fa fa-heart" aria-hidden="true" style="color: #eb7e82;"></i>
                                            @else
                                                <i class="fa fa-heart icon_wish_list_{{ $product->product_id }}" aria-hidden="true"></i>
                                            @endif
                                        </a>
                                    @else
                                        <a href="{{ URL::to('login_client') }}" class="btn wishlist-btn">
                                            @if ($check_already_wish->check_already == 1)
                                                <i class="fa fa-heart" aria-hidden="true" style="color: #eb7e82;"></i>
                                            @else
                                                <i class="fa fa-heart" aria-hidden="true"></i>
                                            @endif
                                        </a>
                                    @endif
                                    {{-- end wish list --}}
                                    @if (Session::get('customer_id'))
                                        <button href="#" class="btn add-to-cart-btn btn-block btn-sm add_cart_one" data-id="{{ $product->product_id }}"><i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                                            thêm vào giỏ hàng
                                        </button>
                                    @else
                                        <a href="{{ URL::to('login_client') }}" class="btn add-to-cart-btn btn-block btn-sm"><i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                                            thêm vào giỏ hàng
                                        </a>
                                    @endif
                                    {{-- add cart --}}
                                    <input type="hidden" class="val_qty_{{ $product->product_id }}" value="1">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                    {{-- end add cart --}}
                                    <a href="#" class="btn compare-btn"><i class="fa fa-random" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                        @if ($price_discount->percent_discount != 0)
                            <div class="content_discount_product">
                                <div class="content_sub_discount bg_discount">
                                    <div class="content_title_discount">
                                        <span class="percent">{{ $price_discount->percent_discount }}%</span>
                                        <span class="txt_giam">giảm</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </li>
            </div>
            {{-- responsive mobile --}}
            <div class="mobile">
                @include('client.layout.responsive_mobile.view_filter_product_mobile')
            </div>
        @endforeach
    </ul>
@else
    {{-- check type filter --}}
    @if (isset($type_filter))
        <input type="hidden" class="type_filter" value="{{ $type_filter }}">
        <input type="hidden" class="level_filter" value="{{ $level_filter }}">
        @if (isset($level_filter_price_start))
            <input type="hidden" class="level_filter_price_start" value="{{ $level_filter_price_start }}">
            <input type="hidden" class="level_filter_price_end" value="{{ $level_filter_price_end }}">
        @else
            <input type="hidden" class="level_filter_price_start" value="">
            <input type="hidden" class="level_filter_price_end" value="">
        @endif
    @else
        <input type="hidden" class="type_filter" value="">
        <input type="hidden" class="level_filter" value="">
    @endif
    {{--  --}}
    <div class="content_anount_search_not_found">
        <div class="anounce_search_none">
            Không tìm thấy kết quả nào
        </div>
        <img src="{{ asset('public/upload/search_not_found.jpg') }}" class="image_not_found" alt="">
    </div>
@endif
<script src="{{ asset('public/font_end/assets/js/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('public/font_end/custom/custom.js') }}"></script>
<script src="{{ asset('public/font_end/custom/update_cart_ajax.js') }}"></script>
<script src="{{ asset('public/font_end/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('public/font_end/custom/mini_detail_product.js') }}"></script>
<script src="{{ asset('public/font_end/custom_ui/js/ajax_wish_list.js') }}"></script>
{{-- <script src="{{ asset('public/font_end/custom_ui/js/recently_viewed.js') }}"></script> --}}
