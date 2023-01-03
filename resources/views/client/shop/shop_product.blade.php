@extends('client.layout_client')
@section('content_body')
    <link rel="stylesheet" href="{{ asset('public/font_end/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/font_end/custom_ui/css/view_search.css') }}">
    <link rel="stylesheet" href="{{ asset('public/font_end/custom/mini_detail_product.css') }}">
    <link rel="stylesheet" href="{{ asset('public/font_end/custom_ui/css/custom_container_product.css') }}">
    <link rel="stylesheet" href="{{ asset('public/font_end/custom_ui/css/custom_cart_lg.css') }}">
    <link rel="stylesheet" href="{{ asset('public/font_end/custom_ui/css/custom_cart_sm.css') }}">
    <link rel="stylesheet" href="{{ asset('public/font_end/custom_ui/css/custom_cart_sm_shop.css') }}">
    <link rel="stylesheet" href="{{ asset('public/font_end/custom_ui/css/modal_filter_ajax_shop.css') }}">
    <link rel="stylesheet" href="{{ asset('public/font_end/custom_ui/css/change_css.css') }}">
    <link rel="stylesheet" href="{{ asset('public/font_end/custom_ui/css/custom_breadcrumb.css') }}">
    <style>
        .btn:focus,
        .btn:active:focus,
        .btn.active:focus,
        .btn.focus,
        .btn:active.focus,
        .btn.active.focus {
            outline: none;
        }

        a:hover {
            text-decoration: none;
        }

        a:focus {
            outline: none;
            text-decoration: none;
        }

        @media (min-width: 1200px) {
            .container {
                width: 1200px;
            }

            .main-content {
                background-color: rgb(245, 245, 245);
            }
        }

        .nice-select .list {
            overflow: auto;
        }

        .nice-select .current {
            color: black;
        }

        #myList li {
            display: none;
        }

        #loadMore {
            display: none;
            color: var(--radius-color);
            cursor: pointer;
            font-size: 16px;
            font-style: italic;
            text-align: center;
            text-decoration: underline;
            margin-top: 8px;
        }

        #loadMore:hover {
            color: black;
        }

        #loadLess {
            display: none;
            color: var(--radius-color);
            cursor: pointer;
            font-size: 16px;
            font-style: italic;
            text-align: center;
            text-decoration: underline;
            margin-top: 8px;
        }

        #loadLess:hover {
            color: black;
        }

        /* body{
                                                        font-family: 'Inter', sans-serif;
                                                    } */

    </style>
    <div class="content_view_search">
        <div class="container laptop">
            <nav class="biolife-nav cus_breadcrumb">
                <ul>
                    <li class="nav-item"><a href="{{ URL::to('/') }}" class="permal-link">Trang chủ</a></li>
                    <li class="nav-item"><span class="current-page">Cửa hàng</span></li>
                </ul>
            </nav>
        </div>
        <div class="container" style="padding-left: 0px; padding-right: 0px">
            <div class="content_product_search">
                <div class="page-contain category-page left-sidebar">
                    <div class="container">
                        <div class="row">
                            <!-- Main content -->
                            <div id="main-content" class="main-content col-lg-9 col-md-8 col-sm-12 col-xs-12">
                                {{-- sort --}}
                                <div class="product-category grid-style">
                                    <div id="top-functions-area" class="top-functions-area">
                                        <div class="flt-item to-left group-on-mobile">
                                            <span class="flt-title">Sắp xếp theo</span>
                                            <a href="#" class="icon-for-mobile">
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                            </a>
                                            <div class="wrap-selectors">
                                                <form action="#" name="frm-refine" method="get">
                                                    <span class="title-for-mobile">Sắp xếp theo</span>
                                                    <div data-title="Price:" class="selector-item">
                                                        <select name="sort_price_fiter" class="sort_price_ajax_shop_select">
                                                            <option value="">Giá</option>
                                                            <option value="desc">Giá: Thấp đến Cao</option>
                                                            <option value="asc">Giá: Cao đến Thấp</option>
                                                        </select>
                                                    </div>
                                                    <div data-title="Rating:" class="selector-item">
                                                        <select name="sort_rating_fiter" class="sort_rating_ajax_shop_select">
                                                            <option value="">Đánh Giá</option>
                                                            <option value="desc">Đánh Giá: Thấp đến Cao</option>
                                                            <option value="asc">Đánh Giá: Cao đến Thấp</option>
                                                        </select>
                                                    </div>
                                                    <div data-title="Much sell:" class="selector-item">
                                                        <select name="sort_discount_fiter" class="sort_discount_ajax_shop_select">
                                                            <option value="">Giảm Giá</option>
                                                            <option value="desc">Giảm Giá: Thấp đến Cao</option>
                                                            <option value="asc">Giảm Giá: Cao đến Thấp</option>
                                                        </select>
                                                    </div>

                                                    {{-- <p class="btn-for-mobile">
                                                        <button type="button" class="btn-submit sort_product_mobile">Lọc</button>
                                                    </p> --}}
                                                </form>
                                            </div>
                                        </div>
                                        <div class="flt-item to-right">
                                            <div class="">
                                                <div class="">
                                                    <button class="btn btn_open_modal_filter" style="background: var(--radius-color); cursor: pointer;"><i class="fa fa-filter" style="color: white; font-size: 24px"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- content_list_product_sort_ajax_shop --}}
                                    <div class="row content_list_product_sort_ajax_shop">
                                        {{-- check type filter --}}
                                        <input type="hidden" class="type_filter" value="">
                                        <input type="hidden" class="level_filter" value="">
                                        <input type="hidden" class="level_filter_price_start" value="">
                                        <input type="hidden" class="level_filter_price_end" value="">
                                        {{--  --}}
                                        {{-- all product discount --}}
                                        @if (count($all_product_discount) > 0)
                                            {{-- respnsive laptop --}}
                                            <div class="laptop">
                                                <div class="row">
                                                    <div class="content_bg_item_sm_shop">
                                                        <div class="content_tab_header">
                                                            <div class="title_tab_header">
                                                                SẢN PHẨM KHUYẾN MÃI
                                                            </div>
                                                            <div class="see_more_tab_header">
                                                                <a href="{{ URL::to('show_all_product_discount') }}" class="tab__head-link">
                                                                    Xem tất cả <span class="icon-copy ti-angle-right"></span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="tab-content">
                                                            <div id="main-content" class="main-content col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <div class="block-item recently-products-cat md-margin-bottom-39 custom-container-product">
                                                                    <ul class="products-list biolife-carousel nav-center-02 nav-none-on-mobile"
                                                                        data-slick='{"rows":1,"arrows":true,"dots":false,"infinite":false,"speed":400,"slidesMargin":0,"slidesToShow":4, "responsive":[{"breakpoint":1200, "settings":{ "slidesToShow": 3}},{"breakpoint":992, "settings":{ "slidesToShow": 3, "slidesMargin":30}},{"breakpoint":768, "settings":{ "slidesToShow": 2, "slidesMargin":10}}]}'>
                                                                        @foreach ($all_product_discount as $product)
                                                                            @php
                                                                                $price_discount = App\Http\Controllers\HomeClientController::check_price_discount($product->product_id);
                                                                                $info_rating_saled = App\Http\Controllers\HomeClientController::info_rating_saled($product->product_id);
                                                                                $check_already_wish = App\Http\Controllers\WishListController::checkProductWishLish($product->product_id);
                                                                            @endphp
                                                                            <li class="product-item col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                                                                <div class="contain-product layout-default content_product_sm_shop" style="width: 197px">
                                                                                    <div class="product-thumb">
                                                                                        <form>
                                                                                            @csrf
                                                                                            <input type="hidden" value="{{ $product->product_name }}" id="recently_viewed_product_name_{{ $product->product_id }}">
                                                                                            <input type="hidden" value="{{ number_format($price_discount->price_now, 0, ',', '.') }}₫" id="recently_viewed_product_price_{{ $product->product_id }}">
                                                                                        </form>
                                                                                        <a href="{{ URL::to('product_detail_slug/' . $product->slug) }}" class="link-to-product btn_recently_viewed" data-id="{{ $product->product_id }}"
                                                                                            id="recently_viewed_product_detail_{{ $product->product_id }}">
                                                                                            <img src="{{ asset('public/upload/' . $product->product_image) }}" alt="dd" style="width: 177px; height: 177px" class="product-thumnail"
                                                                                                id="recently_viewed_product_img_{{ $product->product_id }}">
                                                                                        </a>
                                                                                        <span href="#" class="lookup get_val_quickview btn_call_quickview_detail btn_open_modal" data-id="{{ $product->product_id }}"><i
                                                                                                class="biolife-icon icon-search"></i></span>
                                                                                    </div>
                                                                                    <div class="info">
                                                                                        <h4 class="product-title">
                                                                                            <a href="{{ URL::to('product_detail_slug/' . $product->slug) }}" class="pr-name name_product cus_prod_name_card_sm btn_recently_viewed"
                                                                                                data-id="{{ $product->product_id }}">
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
                                                                                        <div class="content_qty_rating content_qty_rating_sm_shop">
                                                                                            <div class="rating" style="display: flex;">
                                                                                                <p class="star-rating" style="align-self: flex-start">
                                                                                                    <span class="width-80percent" style="width:{{ $info_rating_saled->avg_rating * 20 }}%"></span>
                                                                                                </p>
                                                                                            </div>
                                                                                            <div class="availeble_product" style="font-size: 13px">Đã bán: {{ $info_rating_saled->count_product_saled }}</div>
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
                                                                                                    <button href="#" class="btn add-to-cart-btn btn-block btn-sm add_cart_one" data-id="{{ $product->product_id }}" style="font-size: 10px;"><i
                                                                                                            class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                                                                                                        thêm vào giỏ hàng
                                                                                                    </button>
                                                                                                @else
                                                                                                    <a href="{{ URL::to('login_client') }}" class="btn add-to-cart-btn btn-block btn-sm" style="font-size: 10px;"><i class="fa fa-cart-arrow-down"
                                                                                                            aria-hidden="true"></i>
                                                                                                        thêm vào giỏ hàng
                                                                                                    </a>
                                                                                                @endif
                                                                                                {{-- add cart --}}
                                                                                                <input type="hidden" class="val_qty_{{ $product->product_id }}" value="1">
                                                                                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                                                                {{-- end add cart --}}
                                                                                                <a href="#" class="btn compare-btn"><i class="fa fa-random" aria-hidden="true" style="font-size: 13px"></i></a>
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
                                                </div>
                                            </div>
                                            {{-- resonsive mobile --}}
                                            <div class="mobile">
                                                @include('client.layout.responsive_mobile.view_show_shop_product_discount')
                                            </div>

                                        @endif
                                        {{-- recommend --}}
                                        @if (count($all_product_recommend) > 0)
                                            {{-- latop --}}
                                            <div class="laptop">
                                                <div class="row">
                                                    <div class="content_bg_item_sm_shop">
                                                        <div class="content_tab_header" style="margin-bottom: 0px">
                                                            <div class="title_tab_header">
                                                                GỢI Ý HÔM NAY
                                                            </div>
                                                            <div class="see_more_tab_header">
                                                                {{-- <a href="{{ URL::to('show_all_product_feature') }}" class="tab__head-link">
                                                                    Xem tất cả <span class="icon-copy ti-angle-right"></span>
                                                                </a> --}}
                                                            </div>
                                                        </div>
                                                        <ul class="products-list" style="list-style-type: none;">
                                                            @foreach ($all_product_recommend as $product)
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
                                                                                <img src="{{ asset('public/upload/' . $product->product_image) }}" alt="dd" style="width: 270px; height: 270px" class="product-thumnail"
                                                                                    id="recently_viewed_product_img_{{ $product->product_id }}">
                                                                            </a>
                                                                            <span href="#" class="lookup get_val_quickview btn_call_quickview_detail btn_open_modal" data-id="{{ $product->product_id }}"><i class="biolife-icon icon-search"></i></span>
                                                                        </div>
                                                                        <div class="info">
                                                                            <h4 class="product-title">
                                                                                <a href="{{ URL::to('product_detail_slug/' . $product->slug) }}" class="pr-name name_product btn_recently_viewed"
                                                                                    data-id="{{ $product->product_id }}">{{ $product->product_name }}</a>
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
                                                                                <div class="availeble_product">Đã bán: {{ $info_rating_saled->count_product_saled }}</div>
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
                                                                                        <button href="#" class="btn add-to-cart-btn btn-block btn-sm add_cart_one" data-id="{{ $product->product_id }}"><i class="fa fa-cart-arrow-down"
                                                                                                aria-hidden="true"></i>
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
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- resonsive mobile --}}
                                            <div class="mobile">
                                                @include('client.layout.responsive_mobile.view_show_shop_product_recommend')
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            {{-- Val Nescessary --}}
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            {{-- End Val Nescessary --}}

                            <aside id="sidebar" class="sidebar col-lg-3 col-md-4 col-sm-12 col-xs-12">
                                <div class="biolife-mobile-panels">
                                    <span class="biolife-current-panel-title">Sidebar</span>
                                    <a class="biolife-close-btn" href="#" data-object="open-mobile-filter">&times;</a>
                                </div>
                                <div class="sidebar-contain">
                                    <div class="widget biolife-filter content_left_side_custom">
                                        <h4 class="wgt-title">Theo Danh mục</h4>
                                        <div class="wgt-content">
                                            <ul class="check-list single">
                                                @foreach ($all_category as $cate)
                                                    <li class="check-list-item check_cus_cate">
                                                        <a href="#" class="check-link choose_cate_sort_ajax_shop" data-id="{{ $cate->cate_id }}">{{ $cate->cate_name }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="widget price-filter biolife-filter content_left_side_custom">
                                        <h4 class="wgt-title">Khoảng Giá</h4>
                                        <div class="wgt-content">
                                            <div class="frm-contain content_filter_price">
                                                <form style="text-align: center">
                                                    @csrf
                                                    <div class="content_val_filter_price">
                                                        <p class="f-item">
                                                            <input class="input-number val_price_sort_start" type="number" id="pr-from" value="" name="price-from" placeholder="₫ Từ">
                                                        </p>
                                                        <p class="f-item">
                                                            <input class="input-number val_price_sort_end" type="number" id="pr-to" value="" name="price-from" placeholder="₫ Đến">
                                                        </p>
                                                    </div>
                                                    <p class="f-item"><button type="button" class="btn-submit btn_filter_price btn_sort_price_ajax_shop" type="submit" style="border-radius: 5px">ÁP DỤNG</button></p>
                                                </form>
                                            </div>
                                            <ul class="check-list bold single">
                                                <li class="check-list-item check_cus_price">
                                                    <a href="#" class="check-link check_sort_price_ajax_shop" data-id="1">1.000₫ - 50.000₫</a>
                                                </li>
                                                <li class="check-list-item check_cus_price">
                                                    <a href="#" class="check-link check_sort_price_ajax_shop" data-id="2">50.000₫ - 100.000₫</a>
                                                </li>
                                                <li class="check-list-item check_cus_price">
                                                    <a href="#" class="check-link check_sort_price_ajax_shop" data-id="3">100.000₫ - 500.000₫</a>
                                                </li>
                                                <li class="check-list-item check_cus_price">
                                                    <a href="#" class="check-link check_sort_price_ajax_shop" data-id="4">500.000₫ - 1.000.000₫</a>
                                                </li>
                                                <li class="check-list-item check_cus_price">
                                                    <a href="#" class="check-link check_sort_price_ajax_shop" data-id="5">Trên 1.000.000₫</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="widget biolife-filter content_left_side_custom">
                                        <h4 class="wgt-title">Đánh giá</h4>
                                        <div class="wgt-content content_choose_rating">
                                            <ul class="cat-list">
                                                <li class="cat-list-item check_cus_rating">
                                                    <a class="cat-link pointer choose_rating_sort_ajax_shop" data-id="5">
                                                        <div class="rating" style="display: flex;">
                                                            <p class="star-rating" style="align-self: center">
                                                                <span class="width-80percent" style="width:100%"></span>
                                                            </p>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="cat-list-item check_cus_rating">
                                                    <a class="cat-link pointer choose_rating_sort_ajax_shop" data-id="4">
                                                        <div class="rating" style="display: flex;">
                                                            <p class="star-rating" style="align-self: center">
                                                                <span class="width-80percent" style="width:80%"></span>
                                                            </p>
                                                            <div class="">trở lên</div>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="cat-list-item check_cus_rating">
                                                    <a class="cat-link pointer choose_rating_sort_ajax_shop" data-id="3">
                                                        <div class="rating" style="display: flex;">
                                                            <p class="star-rating" style="align-self: center">
                                                                <span class="width-80percent" style="width:60%"></span>
                                                            </p>
                                                            <div class="">trở lên</div>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="cat-list-item check_cus_rating">
                                                    <a class="cat-link pointer choose_rating_sort_ajax_shop" data-id="2">
                                                        <div class="rating" style="display: flex;">
                                                            <p class="star-rating" style="align-self: center">
                                                                <span class="width-80percent" style="width:40%"></span>
                                                            </p>
                                                            <div class="">trở lên</div>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="cat-list-item check_cus_rating">
                                                    <a class="cat-link pointer choose_rating_sort_ajax_shop" data-id="1">
                                                        <div class="rating" style="display: flex;">
                                                            <p class="star-rating" style="align-self: center">
                                                                <span class="width-80percent" style="width:20%"></span>
                                                            </p>
                                                            <div class="">trở lên</div>
                                                        </div>

                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="widget biolife-filter content_left_side_custom">
                                        <h4 class="wgt-title">Sản phẩm đã xem</h4>
                                        <div class="wgt-content">
                                            <ul class="products content_recently_viewed" id="myList">
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </aside>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal show mini detail product --}}
    <div class="modal_mini_detail modal">
        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header-mini_prod">
                <span class="close close_modal">&times;</span>
            </div>
            <div class="modal_body_mini_prod content_mini_detail">

            </div>
        </div>
    </div>

    {{-- modal filter ajax shop --}}
    <div id="modal_filter" class="modal modal_filter">
        <!-- Modal content -->
        <div class="modal-content-filter">
            <div class="modal-header-cus">
                <span class="close close_modal_filter">&times;</span>
                <h4>
                    <i class="fa fa-filter" style="color: black; font-size: 24px">
                    </i>
                    LỌC
                </h4>
            </div>
            <div class="modal-body-cus">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="content_form_filter_ajax_shop">
                    <div class="row pd-10">
                        <div class="content_filter_cate">
                            <span class="title_choose_cate title_to_filter">Danh mục</span>
                            <select name="" class="choose_cate choose_select select_cate_to_filter">
                                <option value="">Chọn danh mục</option>
                                @foreach ($all_category as $cate)
                                    <option value="{{ $cate->cate_id }}">{{ $cate->cate_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row pd-10">
                        <div class="content_filter_cate">
                            <span class="title_choose_cate title_to_filter">Đánh giá</span>
                            <select name="" class="choose_cate choose_select select_rating_to_filter">
                                <option value="0">Đánh giá</option>
                                <option value="5">5 sao</option>
                                <option value="4">4 sao trở lên</option>
                                <option value="3">3 sao trở lên</option>
                                <option value="2">2 sao trở lên</option>
                                <option value="1">1 sao trở lên</option>
                            </select>
                        </div>
                    </div>
                    <div class="row pd-10">
                        <div class="content_filter_cate ">
                            <span class="title_choose_cate title_to_filter">Khoảng giá</span>
                            <div class="content_price_filter">
                                <input type="number" class="price_start_filter" placeholder="Từ đ" style="border: none; padding: 10px; width: 200px; margin-right: 5px">
                                <input type="number" class="price_end_filter" placeholder="Đến đ" style="border: none; padding: 10px; width: 200px">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-modal-footer-address modal-footer modal_footer_filter_product">
                <button class="btn btn-secondary btn_back_modal" style="margin-right: 10px">TRỞ LẠI</button>
                <button class="btn btn-radius-color btn_filter_modal_shop_many_feature" style="color: #ffffff;">HOÀN THÀNH</button>
            </div>
        </div>
    </div>
    <script src="{{ asset('public/font_end/assets/js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('public/font_end/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/font_end/custom_ui/js/modal_filter_ajax_shop.js') }}"></script>
    <script src="{{ asset('public/font_end/custom/mini_detail_product.js') }}"></script>
    <script src="{{ asset('public/font_end/custom_ui/js/sort_ajax_shop.js') }}"></script>
    <script src="{{ asset('public/font_end/custom_ui/js/recently_viewed.js') }}"></script>
@endsection
