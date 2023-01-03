<div class="Product-box sm-margin-top-30px" style="padding-bottom: 20px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-5 col-sm-6">
                @if (count($all_product_discount_today) > 0)
                    <div class="advance-product-box">
                        <div class="biolife-title-box bold-style biolife-title-box__bold-style">
                            <h3 class="title" style="font-size: 22px;">Khuyến Mãi Sắp Hết</h3>
                        </div>
                        <ul class="products biolife-carousel nav-top-right nav-none-on-mobile" data-slick='{"arrows":true, "dots":false, "infinite":false, "speed":400, "slidesMargin":30, "slidesToShow":1}'>
                            @foreach ($all_product_discount_today as $product)
                                @php
                                    $check_already_wish = App\Http\Controllers\WishListController::checkProductWishLish($product->product_id);
                                    $price_discount = App\Http\Controllers\HomeClientController::check_price_discount($product->product_id);
                                @endphp
                                @if ($price_discount->percent_discount != 0)
                                    <li class="product-item">
                                        <div class="contain-product deal-layout contain-product__deal-layout">
                                            <div class="product-thumb">
                                                <form>
                                                    @csrf
                                                    <input type="hidden" value="{{ $product->product_name }}" id="recently_viewed_product_name_{{ $product->product_id }}">
                                                    <input type="hidden" value="{{ number_format($price_discount->price_now, 0, ',', '.') }}₫" id="recently_viewed_product_price_{{ $product->product_id }}">
                                                </form>
                                                <a href="{{ URL::to('product_detail_slug/' . $product->slug) }}" class="link-to-product btn_recently_viewed" data-id="{{ $product->product_id }}"
                                                    id="recently_viewed_product_detail_{{ $product->product_id }}">
                                                    <img src="{{ asset('public/upload/' . $product->product_image) }}" alt="product discount due" style="width: 340px; height: 396px;" class="product-thumnail"
                                                        id="recently_viewed_product_img_{{ $product->product_id }}">
                                                </a>
                                                <div class="labels" style="top:20px; left:20px;">
                                                    @if ($price_discount->percent_discount != 0)
                                                        <span class="sale-label">-{{ $price_discount->percent_discount }}%</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="info">
                                                <div class="biolife-countdown" data-datetime="{{ $price_discount->date_end_discount }}"></div>
                                                <h4 class="product-title"><a href="{{ URL::to('product_detail_slug/' . $product->slug) }}" class="pr-name btn_recently_viewed"
                                                        data-id="{{ $product->product_id }}">{{ $product->product_name }}</a></h4>
                                                <div class="price ">
                                                    @if ($price_discount->percent_discount == 0)
                                                        <ins><span class="price-amount">
                                                                <span class="currencySymbol">{{ number_format($price_discount->price_now, 0, ',', '.') }}₫</span>
                                                        </ins>
                                                    @else
                                                        <ins><span class="price-amount">
                                                                <span class="currencySymbol">{{ number_format($price_discount->price_now, 0, ',', '.') }}₫</span>
                                                        </ins>
                                                        <del><span class="price-amount"><span class="currencySymbol">{{ number_format($price_discount->price_old, 0, ',', '.') }}₫</span></del>
                                                    @endif
                                                </div>
                                                <div class="slide-down-box">
                                                    {{-- add cart --}}
                                                    <input type="hidden" class="val_qty_{{ $product->product_id }}" value="1">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                    {{-- end add cart --}}
                                                    <div class="buttons">
                                                        {{-- wish list --}}
                                                        @if (Session::get('customer_id'))
                                                            <a class="btn wishlist-btn btn_add_wish_lish" style="cursor: pointer;" data-id="{{ $product->product_id }}">
                                                                @if ($check_already_wish->check_already == 1)
                                                                    <i class="fa fa-heart" aria-hidden="true" style="color: var(--radius-color)"></i>
                                                                @else
                                                                    <i class="fa fa-heart icon_wish_list_{{ $product->product_id }}" aria-hidden="true"></i>
                                                                @endif
                                                            </a>
                                                        @else
                                                            <a href="{{ URL::to('login_client') }}" class="btn wishlist-btn">
                                                                @if ($check_already_wish->check_already == 1)
                                                                    <i class="fa fa-heart" aria-hidden="true" style="color: var(--radius-color)"></i>
                                                                @else
                                                                    <i class="fa fa-heart" aria-hidden="true"></i>
                                                                @endif
                                                            </a>
                                                        @endif
                                                        {{-- end wishlist --}}

                                                        {{-- add cart --}}
                                                        @if (Session::get('customer_id'))
                                                            <button class="btn add-to-cart-btn btn-block add_cart_one" data-id="{{ $product->product_id }}">thêm vào giỏ hàng</button>
                                                        @else
                                                            <a href="{{ URL::to('login_client') }}" class="btn add-to-cart-btn btn-block btn-sm">
                                                                thêm vào giỏ hàng
                                                            </a>
                                                        @endif
                                                        <a href="#" class="btn compare-btn"><i class="fa fa-random" aria-hidden="true"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                @elseif(count($all_product_discount) > 0)
                    <div class="advance-product-box">
                        <div class="biolife-title-box bold-style biolife-title-box__bold-style">
                            <h3 class="title" style="font-size: 22px;">Khuyến Mãi</h3>
                        </div>
                        <ul class="products biolife-carousel nav-top-right nav-none-on-mobile" data-slick='{"arrows":true, "dots":false, "infinite":false, "speed":400, "slidesMargin":30, "slidesToShow":1}'>
                            @foreach ($all_product_discount as $product)
                                @php
                                    $check_already_wish = App\Http\Controllers\WishListController::checkProductWishLish($product->product_id);
                                    $price_discount = App\Http\Controllers\HomeClientController::check_price_discount($product->product_id);
                                @endphp
                                @if ($price_discount->percent_discount != 0)
                                    <li class="product-item">
                                        <div class="contain-product deal-layout contain-product__deal-layout">
                                            <div class="product-thumb">
                                                <form>
                                                    @csrf
                                                    <input type="hidden" value="{{ $product->product_name }}" id="recently_viewed_product_name_{{ $product->product_id }}">
                                                    <input type="hidden" value="{{ number_format($price_discount->price_now, 0, ',', '.') }}₫" id="recently_viewed_product_price_{{ $product->product_id }}">
                                                </form>
                                                <a href="{{ URL::to('product_detail_slug/' . $product->slug) }}" class="link-to-product btn_recently_viewed" data-id="{{ $product->product_id }}"
                                                    id="recently_viewed_product_detail_{{ $product->product_id }}">
                                                    <img src="{{ asset('public/upload/' . $product->product_image) }}" alt="product discount due" style="width: 340px; height: 396px;" class="product-thumnail"
                                                        id="recently_viewed_product_img_{{ $product->product_id }}">
                                                </a>
                                                <div class="labels" style="top:20px; left:20px;">
                                                    @if ($price_discount->percent_discount != 0)
                                                        <span class="sale-label">-{{ $price_discount->percent_discount }}%</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="info">
                                                <div class="biolife-countdown" data-datetime="{{ $price_discount->date_end_discount }}"></div>
                                                <h4 class="product-title"><a href="{{ URL::to('product_detail_slug/' . $product->slug) }}" class="pr-name btn_recently_viewed"
                                                        data-id="{{ $product->product_id }}">{{ $product->product_name }}</a></h4>
                                                <div class="price ">
                                                    @if ($price_discount->percent_discount == 0)
                                                        <ins><span class="price-amount">
                                                                <span class="currencySymbol">{{ number_format($price_discount->price_now, 0, ',', '.') }}₫</span>
                                                        </ins>
                                                    @else
                                                        <ins><span class="price-amount">
                                                                <span class="currencySymbol">{{ number_format($price_discount->price_now, 0, ',', '.') }}₫</span>
                                                        </ins>
                                                        <del><span class="price-amount"><span class="currencySymbol">{{ number_format($price_discount->price_old, 0, ',', '.') }}₫</span></del>
                                                    @endif
                                                </div>
                                                <div class="slide-down-box">
                                                    {{-- add cart --}}
                                                    <input type="hidden" class="val_qty_{{ $product->product_id }}" value="1">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                    {{-- end add cart --}}
                                                    <div class="buttons">
                                                        {{-- wish list --}}
                                                        @if (Session::get('customer_id'))
                                                            <a class="btn wishlist-btn btn_add_wish_lish" style="cursor: pointer;" data-id="{{ $product->product_id }}">
                                                                @if ($check_already_wish->check_already == 1)
                                                                    <i class="fa fa-heart" aria-hidden="true" style="color: var(--radius-color);"></i>
                                                                @else
                                                                    <i class="fa fa-heart icon_wish_list_{{ $product->product_id }}" aria-hidden="true"></i>
                                                                @endif
                                                            </a>
                                                        @else
                                                            <a href="{{ URL::to('login_client') }}" class="btn wishlist-btn">
                                                                @if ($check_already_wish->check_already == 1)
                                                                    <i class="fa fa-heart" aria-hidden="true" style="color: var(--radius-color);"></i>
                                                                @else
                                                                    <i class="fa fa-heart" aria-hidden="true"></i>
                                                                @endif
                                                            </a>
                                                        @endif
                                                        {{-- end wishlist --}}

                                                        {{-- add cart --}}
                                                        @if (Session::get('customer_id'))
                                                            <button class="btn add-to-cart-btn btn-block add_cart_one" data-id="{{ $product->product_id }}">thêm vào giỏ hàng</button>
                                                        @else
                                                            <a href="{{ URL::to('login_client') }}" class="btn add-to-cart-btn btn-block btn-sm">
                                                                thêm vào giỏ hàng
                                                            </a>
                                                        @endif
                                                        <a href="#" class="btn compare-btn"><i class="fa fa-random" aria-hidden="true"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <div class="col-lg-8 col-md-7 col-sm-6">
                @if (count($all_product_top_rating) > 0)
                    <div class="advance-product-box">
                        <div class="biolife-title-box bold-style biolife-title-box__bold-style">
                            <h3 class="title" style="font-size: 22px;">Đánh Giá Hàng Đầu</h3>
                        </div>
                        <ul class="products biolife-carousel nav-center-03 nav-none-on-mobile row-space-29px"
                            data-slick='{"rows":2,"arrows":true,"dots":false,"infinite":false,"speed":400,"slidesMargin":30,"slidesToShow":2,"responsive":[{"breakpoint":1200,"settings":{ "rows":2, "slidesToShow": 2}},{"breakpoint":992, "settings":{ "rows":2, "slidesToShow": 1}},{"breakpoint":768, "settings":{ "rows":2, "slidesToShow": 2}},{"breakpoint":500, "settings":{ "rows":2, "slidesToShow": 1}}]}'>
                            @foreach ($all_product_top_rating as $product)
                                @php
                                    $price_discount = App\Http\Controllers\HomeClientController::check_price_discount($product->product_id);
                                    $info_rating_saled = App\Http\Controllers\HomeClientController::info_rating_saled($product->product_id);
                                @endphp
                                <li class="product-item" style="background-color: #fff; position: relative">
                                    <div class="contain-product right-info-layout contain-product__right-info-layout">
                                        <div class="product-thumb">
                                            <form>
                                                @csrf
                                                <input type="hidden" value="{{ $product->product_name }}" id="recently_viewed_product_name_{{ $product->product_id }}">
                                                <input type="hidden" value="{{ number_format($price_discount->price_now, 0, ',', '.') }}₫" id="recently_viewed_product_price_{{ $product->product_id }}">
                                            </form>
                                            <a href="{{ URL::to('product_detail_slug/' . $product->slug) }}" class="link-to-product btn_recently_viewed" data-id="{{ $product->product_id }}"
                                                id="recently_viewed_product_detail_{{ $product->product_id }}">
                                                <img src="{{ asset('public/upload/' . $product->product_image) }}" alt="dd" style="width: 170px; height: 170px" width="270" height="270" class="product-thumnail"
                                                    id="recently_viewed_product_img_{{ $product->product_id }}">
                                            </a>
                                        </div>
                                        <div class="info">
                                            <h4 class="product-title"><a href="{{ URL::to('product_detail_slug/' . $product->slug) }}" class="pr-name btn_recently_viewed" data-id="{{ $product->product_id }}">{{ $product->product_name }}</a>
                                            </h4>
                                            <div class="price ">
                                                @if ($price_discount->percent_discount == 0)
                                                    <ins><span class="price-amount"><span class="currencySymbol">{{ number_format($price_discount->price_now, 0, ',', '.') }}₫</span></ins>
                                                @else
                                                    <ins><span class="price-amount"><span class="currencySymbol">{{ number_format($price_discount->price_now, 0, ',', '.') }}₫</span></ins>
                                                    <del><span class="price-amount"><span class="currencySymbol">{{ number_format($price_discount->price_old, 0, ',', '.') }}₫</span></del>
                                                @endif
                                            </div>
                                            <div class="rating">
                                                <p class="star-rating"><span class="width-80percent" style="width:{{ $info_rating_saled->avg_rating * 20 }}%"></span></p>
                                                <span class="review-count">({{ $info_rating_saled->count_all_rating }} Đánh giá)</span>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($price_discount->percent_discount > 0)
                                        <div class="content_discount_product" style="top: 8px; right: 202px;">
                                            <div class="content_sub_discount bg_discount">
                                                <div class="content_title_discount">
                                                    <span class="percent">{{ $price_discount->percent_discount }}%</span>
                                                    <span class="txt_giam">giảm</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                        <div class="biolife-banner style-01 biolife-banner__style-01 sm-margin-top-30px xs-margin-top-80px">
                            <div class="banner-contain">
                                <a href="#" class="bn-link"></a>
                                <div class="text-content">
                                    <span class="first-line">Sản phẩm luôn luôn</span>
                                    <b class="second-line">CHẤT LƯỢNG</b>
                                    <i class="third-line">GIÁ RẺ</i>
                                    <span class="fourth-line">Chỉ có tại RADIUS Hoa Khô</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @else

                @endif
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('public/font_end/assets/js/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('public/font_end/custom_ui/js/count_down.js') }}"></script>
<script src="{{ asset('public/font_end/custom_ui/js/recently_viewed.js') }}"></script>
