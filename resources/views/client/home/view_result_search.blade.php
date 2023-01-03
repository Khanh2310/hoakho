@extends('client.layout_client')
@section('product_tap_view_client')
    <link rel="stylesheet" href="{{ asset('public/font_end/custom_ui/css/view_search.css') }}">
    <link rel="stylesheet" href="{{ asset('public/font_end/custom_ui/css/custom_cart_lg.css') }}">
    <link rel="stylesheet" href="{{ asset('public/font_end/custom/mini_detail_product.css') }}">
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

    </style>
    <div class="content_view_search">
        <div class="container">
            <nav class="biolife-nav cus_breadcrumb">
                <ul>
                    <li class="nav-item"><a href="{{ URL::to('/') }}" class="permal-link">Trang chủ</a></li>
                    <li class="nav-item"><span class="current-page">Tìm kiếm</span></li>
                </ul>
            </nav>
        </div>
        <div class="container">
            <div class="content_txt_result_search">
                <div class="txt_result">
                    <img src="{{ URL::to('public/upload/light_icon.png') }}" alt="" width="30px">
                    Kết quả tìm kiếm cho từ khóa '<span style="color: var(--radius-color);">{{ $val_search }}</span>'
                </div>
            </div>
            <div class="content_product_search">
                @if (count($result_search) > 0)
                    <div class="page-contain category-page left-sidebar">
                        <div class="container">
                            <div class="row">
                                <!-- Main content -->
                                <div id="main-content" class="main-content col-lg-9 col-md-8 col-sm-12 col-xs-12">

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
                                                            <select name="sort_price_fiter" class="sort_price_fiter">
                                                                <option value="">Giá</option>
                                                                <option value="desc">Giá: Thấp đến Cao</option>
                                                                <option value="asc">Giá: Cao đến Thấp</option>
                                                            </select>
                                                        </div>
                                                        <div data-title="Rating:" class="selector-item content_sort_rating_fiter">
                                                            <select name="sort_rating_fiter" class="sort_rating_fiter">
                                                                <option value="">Đánh Giá</option>
                                                                <option value="desc">Đánh Giá: Thấp đến Cao</option>
                                                                <option value="asc">Đánh Giá: Cao đến Thấp</option>
                                                            </select>
                                                        </div>
                                                        <div data-title="Much sell:" class="selector-item">
                                                            <select name="sort_discount_fiter" class="sort_discount_fiter">
                                                                <option value="">Giảm Giá</option>
                                                                <option value="desc">Giảm Giá: Thấp đến Cao</option>
                                                                <option value="asc">Giảm Giá: Cao đến Thấp</option>
                                                            </select>
                                                        </div>

                                                        <p class="btn-for-mobile"><button type="submit" class="btn-submit">Go</button></p>
                                                    </form>
                                                </div>
                                            </div>
                                            {{-- <div class="flt-item to-right">
                                        <div class="wrap-selectors">
                                            <div class="selector-item viewmode-selector">
                                                <a href="category-grid-left-sidebar.html" class="viewmode grid-mode active"><i class="biolife-icon icon-grid"></i></a>
                                                <a href="category-list-left-sidebar.html" class="viewmode detail-mode"><i class="biolife-icon icon-list"></i></a>
                                            </div>
                                        </div>
                                    </div> --}}
                                        </div>
                                        <div class="row">
                                            <ul class="products-list content_list_product_search" style="list-style-type: none;">
                                                @foreach ($result_search as $product)
                                                    @php
                                                        $price_discount = App\Http\Controllers\HomeClientController::check_price_discount($product->product_id);
                                                        $info_rating_saled = App\Http\Controllers\HomeClientController::info_rating_saled($product->product_id);
                                                        $check_already_wish = App\Http\Controllers\WishListController::checkProductWishLish($product->product_id);
                                                    @endphp
                                                    {{-- check type filter --}}
                                                    <input type="hidden" class="type_filter" value="">
                                                    <input type="hidden" class="level_filter" value="">
                                                    <input type="hidden" class="level_filter_price_start" value="">
                                                    <input type="hidden" class="level_filter_price_end" value="">
                                                    {{--  --}}
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
                                                                        {{-- end wishlist --}}
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
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!-- Sidebar -->

                                {{-- Val Nescessary --}}
                                <input type="hidden" class="keyword_search" value="{{ $val_search }}">
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
                                                            <a href="#" class="check-link choose_cate_search" data-id="{{ $cate->cate_id }}">{{ $cate->cate_name }}</a>
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
                                                                <input class="input-number val_price_filter_start" type="number" id="pr-from" value="" name="price-from" placeholder="₫ Từ">
                                                            </p>
                                                            <p class="f-item">
                                                                <input class="input-number val_price_filter_end" type="number" id="pr-to" value="" name="price-from" placeholder="₫ Đến">
                                                            </p>
                                                        </div>
                                                        <p class="f-item"><button type="button" class="btn-submit btn_filter_price" type="submit" style="border-radius: 5px">ÁP DỤNG</button></p>
                                                    </form>
                                                </div>
                                                <ul class="check-list bold single">
                                                    <li class="check-list-item check_cus_price">
                                                        <a href="#" class="check-link check_filter_price" data-id="1">1.000₫ - 50.000₫</a>
                                                    </li>
                                                    <li class="check-list-item check_cus_price">
                                                        <a href="#" class="check-link check_filter_price" data-id="2">50.000₫ - 100.000₫</a>
                                                    </li>
                                                    <li class="check-list-item check_cus_price">
                                                        <a href="#" class="check-link check_filter_price" data-id="3">100.000₫ - 500.000₫</a>
                                                    </li>
                                                    <li class="check-list-item check_cus_price">
                                                        <a href="#" class="check-link check_filter_price" data-id="4">500.000₫ - 1.000.000₫</a>
                                                    </li>
                                                    <li class="check-list-item check_cus_price">
                                                        <a href="#" class="check-link check_filter_price" data-id="5">Trên 1.000.000₫</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="widget biolife-filter content_left_side_custom">
                                            <h4 class="wgt-title">Đánh giá</h4>
                                            <div class="wgt-content content_choose_rating">
                                                <ul class="cat-list">
                                                    <li class="cat-list-item">
                                                        <a class="cat-link pointer choose_rating_search" data-id="5">
                                                            <div class="rating" style="display: flex;">
                                                                <p class="star-rating" style="align-self: center">
                                                                    <span class="width-80percent" style="width:100%"></span>
                                                                </p>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li class="cat-list-item">
                                                        <a class="cat-link pointer choose_rating_search" data-id="4">
                                                            <div class="rating" style="display: flex;">
                                                                <p class="star-rating" style="align-self: center">
                                                                    <span class="width-80percent" style="width:80%"></span>
                                                                </p>
                                                                <div class="">trở lên</div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li class="cat-list-item">
                                                        <a class="cat-link pointer choose_rating_search" data-id="3">
                                                            <div class="rating" style="display: flex;">
                                                                <p class="star-rating" style="align-self: center">
                                                                    <span class="width-80percent" style="width:60%"></span>
                                                                </p>
                                                                <div class="">trở lên</div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li class="cat-list-item">
                                                        <a class="cat-link pointer choose_rating_search" data-id="2">
                                                            <div class="rating" style="display: flex;">
                                                                <p class="star-rating" style="align-self: center">
                                                                    <span class="width-80percent" style="width:40%"></span>
                                                                </p>
                                                                <div class="">trở lên</div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li class="cat-list-item">
                                                        <a class="cat-link pointer choose_rating_search" data-id="1">
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
                                                    {{-- <div class="">
                                            </div> --}}
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                </aside>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="content_anount_search_not_found">
                        <div class="anounce_search_none">
                            Không tìm thấy kết quả nào
                        </div>
                        <img src="{{ asset('public/upload/search_not_found.jpg') }}" class="image_not_found" alt="">
                    </div>

                @endif
            </div>
        </div>
    </div>
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
    <script src="{{ asset('public/font_end/custom_ui/js/ajax_choose_search.js') }}"></script>
    <script src="{{ asset('public/font_end/custom_ui/js/recently_viewed.js') }}"></script>
@endsection
