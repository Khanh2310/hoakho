@extends('client.layout_client')
{{-- SLIDER --}}
@section('slider_view_client')
    @include('client.layout.body.slider')
@endsection
{{-- load --}}
{{-- @include('client.layout.header_middle.preload') --}}

{{-- TAB SHOW PRODUCT --}}
@section('product_tap_view_client')
    <link rel="stylesheet" href="{{ asset('public/font_end/custom/mini_detail_product.css') }}">
    <link rel="stylesheet" href="{{ asset('public/font_end/custom_ui/css/custom_container_product.css') }}">
    <link rel="stylesheet" href="{{ asset('public/font_end/custom_ui/css/custom_cart_lg.css') }}">
    <link rel="stylesheet" href="{{ asset('public/font_end/custom_ui/css/custom_cart_sm.css') }}">
    <style>
        .btn:focus,
        .btn:active:focus,
        .btn.active:focus,
        .btn.focus,
        .btn:active.focus,
        .btn.active.focus {
            outline: none;
        }

    </style>
    @if (count($all_product_discount) > 0)
        {{-- laptop --}}
        <div class="product-tab z-index-20 bg">
            <div class="container">
                <div class="biolife-tab biolife-tab-contain sm-margin-top-34px container-product laptop">
                    <div class="tab__head">
                        <div class="tab__head-text--title">
                            SẢN PHẨM KHUYẾN MÃI
                        </div>
                        <div class="tab__head-text--see-all">
                            <a href="{{ URL::to('show_all_product_discount') }}" class="tab__head-link">
                                Xem tất cả <span class="icon-copy ti-angle-right"></span>
                            </a>
                        </div>
                    </div>
                    <div class="tab-content">
                        <ul class="products-list biolife-carousel nav-center-02 nav-none-on-mobile eq-height-contain"
                            data-slick='{"rows":1 ,"arrows":true,"dots":false,"infinite":true,"speed":400,"slidesMargin":10,"slidesToShow":4, "responsive":[{"breakpoint":1200, "settings":{ "slidesToShow": 4}},{"breakpoint":992, "settings":{ "slidesToShow": 3, "slidesMargin":20}},{"breakpoint":739, "settings":{ "slidesToShow": 2, "slidesMargin":15}}]}'>
                            @foreach ($all_product_discount as $product)
                                @php
                                    $price_discount = App\Http\Controllers\HomeClientController::check_price_discount($product->product_id);
                                    $info_rating_saled = App\Http\Controllers\HomeClientController::info_rating_saled($product->product_id);
                                    $check_already_wish = App\Http\Controllers\WishListController::checkProductWishLish($product->product_id);
                                @endphp
                                <li class="product-item col-lg-4 col-md-4 col-sm-4 col-xs-6">
                                    <div class="contain-product layout-default content_product">
                                        <div class="product-thumb">
                                            <form>
                                                @csrf
                                                <input type="hidden" value="{{ $product->product_name }}" id="recently_viewed_product_name_{{ $product->product_id }}">
                                                <input type="hidden" value="{{ number_format($price_discount->price_now, 0, ',', '.') }}₫" id="recently_viewed_product_price_{{ $product->product_id }}">
                                            </form>
                                            <a href="{{ URL::to('product_detail_slug/' . $product->slug) }}" class="link-to-product btn_recently_viewed" data-id="{{ $product->product_id }}"
                                                id="recently_viewed_product_detail_{{ $product->product_id }}">
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
                                                <div class="rating" style="display: flex;">
                                                    <p class="star-rating" style="align-self: flex-start">
                                                        <span class="width-80percent" style="width:{{ $info_rating_saled->avg_rating * 20 }}%"></span>
                                                    </p>
                                                </div>
                                                <div class="availeble_product" style="font-size: 14px">Đã bán: {{ $info_rating_saled->count_product_saled }}</div>
                                            </div>
                                            <div class="slide-down-box">
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
                                                        <button href="#" class="btn add-to-cart-btn btn-block btn-sm add_cart_one" data-id="{{ $product->product_id }}" style="width: 175px;">
                                                            <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                                                            thêm vào giỏ hàng
                                                        </button>
                                                    @else
                                                        <a href="{{ URL::to('login_client') }}" class="btn add-to-cart-btn btn-block btn-sm" style="width: 175px;">
                                                            <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
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
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        {{-- mobile --}}
        @include('client.layout.responsive_mobile.product_discount')


        {{--  --}}
        <div class="container laptop">
            <div class="content_advertisement_img" style="display: flex;">
                <img src="{{ asset('public/upload/sale1.jpg') }}" alt="" style="width: 400px; height: 110px;">
                <img src="{{ asset('public/upload/sale2.jpg') }}" alt="" style="width: 400px; height: 110px;">
                <img src="{{ asset('public/upload/sale3.jpg') }}" alt="" style="width: 400px; height: 110px;">
            </div>
        </div>
    @endif
    <!-- The Modal mini detail product -->
    <div class="modal_mini_detail modal">
        <!-- Modal content -->
        <div class="modal-content container">
            <div class="modal-header-mini_prod">
                <span class="close close_modal">&times;</span>
            </div>
            <div class="modal_body_mini_prod content_mini_detail">

            </div>
        </div>
    </div>
    <script src="{{ asset('public/font_end/assets/js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('public/font_end/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/font_end/custom/mini_detail_product.js') }}"></script>
@endsection
@section('content_body')
    <!--Block 17: Banners-->
    <div class="banner-block sm-margin-top-30px xs-margin-top-50px">
        <div class="container">
            <ul class="grid-twice-item">
                <li>
                    <div class="biolife-banner biolife-banner__style-11">
                        <div class="banner-contain">
                            <div class="media">
                                <a href="#" class="bn-link"><img src="{{ asset('public/upload/bg-vege1.jpg') }}" width="281" height="auto" alt=""></a>
                            </div>
                            <div class="text-content">
                                <span class="text1">CỬA HÀNG</span>
                                <b class="text2">RADIUS HOA KHÔ</b>
                                <span class="text3">KHUYẾN MÃI</span>
                                <b class="text4">ƯU ĐÃI ĐẾN 50%</b>
                                <a href="{{ URL::to('shop_product') }}" class="btn btn-thin">Cửa Hàng</a>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="biolife-banner biolife-banner__style-12">
                        <div class="banner-contain">
                            <div class="media">
                                <a href="#" class="bn-link"><img src="{{ asset('public/upload/bg-all.jpg') }}" width="281" height="auto" alt=""></a>
                            </div>
                            <div class="text-content">
                                <i class="text1">Đảm Bảo</i>
                                <b class="text2">100% SẢN PHẨM GIỐNG HÌNH</b>
                                <a href="{{ URL::to('shop_product') }}" class="btn btn-thin">Cửa Hàng</a>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    {{-- PRODUCT FEATURE --}}
    @if (count($all_product_feature) > 0)
        <div class="product-tab z-index-20 bg laptop">
            <div class="container">
                <div class="biolife-tab biolife-tab-contain sm-margin-top-34px container-product">
                    <div class="tab__head">
                        <div class="tab__head-text--title">
                            SẢN PHẨM ĐẶC TRƯNG
                        </div>
                        <div class="tab__head-text--see-all">
                            <a href="{{ URL::to('show_all_product_feature') }}" class="tab__head-link">
                                Xem tất cả <span class="icon-copy ti-angle-right"></span>
                            </a>
                        </div>
                    </div>
                    <div class="tab-content">
                        <ul class="products-list biolife-carousel nav-center-02 nav-none-on-mobile eq-height-contain"
                            data-slick='{"rows":1 ,"arrows":true,"dots":false,"infinite":true,"speed":400,"slidesMargin":10,"slidesToShow":4, "responsive":[{"breakpoint":1200, "settings":{ "slidesToShow": 4}},{"breakpoint":992, "settings":{ "slidesToShow": 3, "slidesMargin":20}},{"breakpoint":768, "settings":{ "slidesToShow": 2, "slidesMargin":15}}]}'>
                            @foreach ($all_product_feature as $product)
                                @php
                                    $price_discount = App\Http\Controllers\HomeClientController::check_price_discount($product->product_id);
                                    $info_rating_saled = App\Http\Controllers\HomeClientController::info_rating_saled($product->product_id);
                                    $check_already_wish = App\Http\Controllers\WishListController::checkProductWishLish($product->product_id);
                                @endphp
                                <li class="product-item col-lg-4 col-md-4 col-sm-4 col-xs-6">
                                    <div class="contain-product layout-default content_product">
                                        <div class="product-thumb">
                                            <form>
                                                @csrf
                                                <input type="hidden" value="{{ $product->product_name }}" id="recently_viewed_product_name_{{ $product->product_id }}">
                                                <input type="hidden" value="{{ number_format($price_discount->price_now, 0, ',', '.') }}₫" id="recently_viewed_product_price_{{ $product->product_id }}">
                                            </form>
                                            <a href="{{ URL::to('product_detail_slug/' . $product->slug) }}" class="link-to-product btn_recently_viewed" data-id="{{ $product->product_id }}"
                                                id="recently_viewed_product_detail_{{ $product->product_id }}">
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
                                                <div class="rating" style="display: flex;">
                                                    <p class="star-rating" style="align-self: flex-start">
                                                        <span class="width-80percent" style="width:{{ $info_rating_saled->avg_rating * 20 }}%"></span>
                                                    </p>
                                                </div>
                                                <div class="availeble_product" style="font-size: 14px">Đã bán: {{ $info_rating_saled->count_product_saled }}</div>
                                            </div>
                                            <div class="slide-down-box">
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
                                                    {{-- end wishlist --}}
                                                    @if (Session::get('customer_id'))
                                                        <button href="#" class="btn add-to-cart-btn btn-block btn-sm add_cart_one" data-id="{{ $product->product_id }}" style="width: 175px;">
                                                            <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                                                            thêm vào giỏ hàng
                                                        </button>
                                                    @else
                                                        <a href="{{ URL::to('login_client') }}" class="btn add-to-cart-btn btn-block btn-sm" style="width: 175px;">
                                                            <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
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
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        {{-- mobile --}}
        @include('client.layout.responsive_mobile.product_feature')
    @endif
    {{--  --}}
    {{-- <div class="container" style="background-color: #fff; border-bottom: 1px solid rgba(0, 0, 0, 0.09); padding: 15px"> --}}
    {{-- <div class="biolife-service type01 biolife-service__type01 sm-margin-top-0 xs-margin-top-45px">
        <b class="txt-show-01">100%</b>
        <i class="txt-show-02" style="font-family: cursive">MKU FOOD</i>
        <ul class="services-list">
            <li>
                <div class="service-inner color-reverse">
                    <span class="number">1</span>
                    <span class="biolife-icon icon-beer"></span>
                    <a class="srv-name" href="#">sản phẩm chất lượng</a>
                </div>
            </li>
            <li>
                <div class="service-inner color-reverse">
                    <span class="number">2</span>
                    <span class="biolife-icon icon-schedule"></span>
                    <a class="srv-name" href="#">làm việc 24/7</a>
                </div>
            </li>
            <li>
                <div class="service-inner color-reverse">
                    <span class="number">3</span>
                    <span class="biolife-icon icon-car"></span>
                    <a class="srv-name" href="#">Giao Hàng Nhanh</a>
                </div>
            </li>
        </ul>
    </div> --}}
    {{-- </div> --}}


    {{-- RECOMMENT PRODUCT --}}
    <div class="container laptop">
        <div class="row">
            <div id="main-content" class="main-content col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="block-item head__title" style="display: flex; justify-content: space-between">
                    <div class="head__title--text">
                        Gợi ý hôm nay
                    </div>
                    <div class="tab__head-text--see-all" style="padding-right: 10px">
                        <a href="{{ URL::to('show_all_product_recommend') }}" class="tab__head-link">
                            Xem tất cả <span class="icon-copy ti-angle-right"></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Main content -->
            <div id="main-content" class="main-content col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="block-item recently-products-cat md-margin-bottom-39 custom-container-product">
                    <ul class="products-list biolife-carousel nav-center-02 nav-none-on-mobile"
                        data-slick='{"rows":1,"arrows":true,"dots":false,"infinite":false,"speed":400,"slidesMargin":0,"slidesToShow":5, "responsive":[{"breakpoint":1200, "settings":{ "slidesToShow": 3}},{"breakpoint":992, "settings":{ "slidesToShow": 3, "slidesMargin":30}},{"breakpoint":768, "settings":{ "slidesToShow": 2, "slidesMargin":10}}]}'>
                        @foreach ($all_product_join as $product)
                            @php
                                $price_discount = App\Http\Controllers\HomeClientController::check_price_discount($product->product_id);
                                $info_rating_saled = App\Http\Controllers\HomeClientController::info_rating_saled($product->product_id);
                                $check_already_wish = App\Http\Controllers\WishListController::checkProductWishLish($product->product_id);
                            @endphp
                            <li class="product-item col-lg-4 col-md-4 col-sm-4 col-xs-6">
                                <div class="contain-product layout-default content_product_sm">
                                    <div class="product-thumb">
                                        <form>
                                            @csrf
                                            <input type="hidden" value="{{ $product->product_name }}" id="recently_viewed_product_name_{{ $product->product_id }}">
                                            <input type="hidden" value="{{ number_format($price_discount->price_now, 0, ',', '.') }}₫" id="recently_viewed_product_price_{{ $product->product_id }}">
                                        </form>
                                        <a href="{{ URL::to('product_detail_slug/' . $product->slug) }}" class="link-to-product btn_recently_viewed" data-id="{{ $product->product_id }}"
                                            id="recently_viewed_product_detail_{{ $product->product_id }}">
                                            <img src="{{ asset('public/upload/' . $product->product_image) }}" alt="dd" style="width: 220px; height: 220px" class="product-thumnail" id="recently_viewed_product_img_{{ $product->product_id }}">
                                        </a>
                                        <span href="#" class="lookup get_val_quickview btn_call_quickview_detail btn_open_modal" data-id="{{ $product->product_id }}"><i class="biolife-icon icon-search"></i></span>
                                    </div>
                                    <div class="info">
                                        <h4 class="product-title">
                                            <a href="{{ URL::to('product_detail_slug/' . $product->slug) }}" class="pr-name name_product cus_prod_name_card_sm btn_recently_viewed" data-id="{{ $product->product_id }}">
                                                {{ $product->product_name }}
                                            </a>
                                        </h4>
                                        <div class="price">
                                            @if ($price_discount->percent_discount == 0)
                                                <ins><span class="price-amount cus_price_card_sm" style="font-size: 16px;">
                                                        <span class="currencySymbol">{{ number_format($price_discount->price_now, 0, ',', '.') }}₫</span>
                                                </ins>
                                            @else
                                                <ins><span class="price-amount cus_price_card_sm" style="font-size: 16px;">
                                                        <span class="currencySymbol">{{ number_format($price_discount->price_now, 0, ',', '.') }}₫</span>
                                                </ins>
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
                                            <div class="buttons" style="padding: 0px;">
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
                                                    <button href="#" class="btn add-to-cart-btn btn-block btn-sm add_cart_one" data-id="{{ $product->product_id }}" style="font-size: 12px;"><i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                                                        thêm vào giỏ hàng
                                                    </button>
                                                @else
                                                    <a href="{{ URL::to('login_client') }}" class="btn add-to-cart-btn btn-block btn-sm" style="font-size: 12px;"><i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
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
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    {{-- mobile recommend product --}}
    @include('client.layout.responsive_mobile.product_recomment')

    <script src="{{ asset('public/font_end/custom_ui/js/recently_viewed.js') }}"></script>
@endsection
@section('top_rate_product_view_client')
    @include('client.layout.body.top_rate_product')
@endsection
