@extends('client.layout_client')
@section('content_body')
    @php
    $total_rating = count($all_rating_to_count);
    if ($total_rating != 0) {
        $persen_rating_5 = number_format(($rating_5 / $total_rating) * 100, 0, ',', '.');
        $persen_rating_4 = number_format(($rating_4 / $total_rating) * 100, 0, ',', '.');
        $persen_rating_3 = number_format(($rating_3 / $total_rating) * 100, 0, ',', '.');
        $persen_rating_2 = number_format(($rating_2 / $total_rating) * 100, 0, ',', '.');
        $persen_rating_1 = 100 - $persen_rating_5 - $persen_rating_4 - $persen_rating_3 - $persen_rating_2;

        $avg_rating = ($rating_5 * 5 + $rating_4 * 4 + $rating_3 * 3 + $rating_2 * 2 + $rating_1 * 1) / $total_rating;
    } else {
        $persen_rating_5 = 0;
        $persen_rating_4 = 0;
        $persen_rating_3 = 0;
        $persen_rating_2 = 0;
        $persen_rating_1 = 0;
        $avg_rating = 0;
    }
    //
    $price_discount = App\Http\Controllers\HomeClientController::check_price_discount($product->product_id);
    $info_rating_saled = App\Http\Controllers\HomeClientController::info_rating_saled($product->product_id);
    @endphp
    <link rel="stylesheet" href="{{ asset('public/font_end/custom/sweet.css') }}">
    <link rel="stylesheet" href="{{ asset('public/font_end/custom/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('public/font_end/custom/custom_home_detail.css') }}">
    <link rel="stylesheet" href="{{ asset('public/font_end/custom/voucher_product_detail.css') }}">
    <link rel="stylesheet" href="{{ asset('public/font_end/custom/custom_background.css') }}">
    <link rel="stylesheet" href="{{ asset('public/font_end/custom_ui/css/custom_container_product.css') }}">
    <link rel="stylesheet" href="{{ asset('public/font_end/custom_ui/css/custom_breadcrumb.css') }}">
    <link rel="stylesheet" href="{{ asset('public/font_end/custom_ui/css/custom_cart_sm.css') }}">
    <link rel="stylesheet" href="{{ asset('public/font_end/custom/mini_detail_product.css') }}">

    <style>
        .text {
            overflow: hidden;
            height: 35px;
            line-height: 18px;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            /* number of lines to show */
            -webkit-box-orient: vertical;
        }

        .btn_buy_now {
            font-size: 15px;
            border: none;
            font-weight: 600;
            padding: 12px 10px 11px;
            width: 200px;
            color: white;
            background-image: linear-gradient(to bottom right, var(--radius-color), #ff6b6b);
        }

    </style>
    <div class="container">
        <nav class="biolife-nav cus_breadcrumb">
            <ul>
                <li class="nav-item"><a href="{{ URL::to('/') }}" class="permal-link">Trang chủ</a></li>
                <li class="nav-item"><span class="current-page">Chi tiết sản phẩm</span></li>
            </ul>
        </nav>
    </div>
    <div class="page-contain single-product">
        <div class="container">
            <!-- Main content -->
            <div id="main-content" class="main-content">

                <!-- summary info -->
                <div class="sumary-product single-layout cus_bg_product_detail" style="min-height: 700px;">
                    <div class="media">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="card">
                                    <div class="carousel card-block">
                                        <img class="card-img-top" src="{{ asset('public/upload/' . $product->product_image) }}" style="height: 428px; width: 428px" />
                                        @foreach ($all_image as $image)
                                            <img class="card-img-top" src="{{ asset('public/upload/' . $image->image) }}" style="height: 428px; width: 428px" />
                                        @endforeach
                                    </div>
                                </div>
                                <div class="carousel-nav card-block slide_image_detail_product">
                                    <img style="width: 89px; height: 89px;" class="card-img-top" src="{{ asset('public/upload/' . $product->product_image) }}" />
                                    @foreach ($all_image as $image)
                                        <img style="width: 89px; height: 89px;" class="card-img-top" src="{{ asset('public/upload/' . $image->image) }}" />
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="product-attribute">
                        <h3 class="title">{{ $product->product_name }}</h3>
                        <div class="rating">
                            <p class="star-rating"><span class="width-80percent" style="width: {{ $avg_rating * 20 }}%"></span></p>
                            <span class="review-count count_rating_on_detail" style="font-size: 15px">({{ count($all_rating_to_count) }} Đánh Giá)</span>
                            <span class="review-count count_comment_on_detail" style="font-size: 15px"> |
                                {{ count($all_comment_to_count) }} Bình Luận</span>
                            <span class="qa-text count_product_saled">{{ $info_rating_saled->count_product_saled }} Đã
                                Bán</span>
                        </div>
                        <span class="sku">Sản phẩm có sẵn :
                            @foreach ($product_storage as $prod_qty)
                                @if ($product->product_id == $prod_qty->product_id)
                                    {{ $prod_qty->total_quantity_product }}
                                @endif
                            @endforeach
                        </span>
                        <p class="">danh mục: {{ $cate->cate_name }}</p>
                        <div class="excerpt text-justify" style="padding-right: 20px">{!! $product->product_sort_desc !!}
                        </div>
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
                                <ins>
                                    <span class="price-amount">
                                        <span class="badge custom_badge">GIẢM {{ $price_discount->percent_discount }}%</span>
                                    </span>
                                </ins>
                            @endif
                        </div>
                        <div @if (count($all_product_voucher) > 0)
                            class="content__voucher content__voucher--hover"
                        @else
                            class="content__voucher"
                            @endif
                            style="padding-top: 14px;">
                            <div class="content__voucher--label">
                                <span>Mã voucher</span>
                            </div>
                            <div class="content__voucher-list">
                                @if (count($all_product_voucher) > 0)
                                    @foreach ($all_product_voucher as $product_voucher)
                                        <div class="content__voucher-item">
                                            {{-- <span>Giảm {{ ($product_voucher->voucher_amount / $price->price) * 100 }}%</span> --}}
                                            <span>Giảm {{ number_format(($product_voucher->voucher_amount / $price->price) * 100, 0, ',', '.') }}%</span>
                                        </div>
                                    @endforeach
                                @else
                                    <span class="content__voucher--text-empty">Hiện sản phẩm không có voucher</span>
                                @endif
                            </div>
                            <div class="container__voucher-list">
                                @foreach ($all_product_voucher as $product_voucher)
                                    <div class="container__voucher-item-detail">
                                        <div class="container__voucher-item--left">
                                            <div class="voucher-item--left-img">
                                                <img src="{{ asset('public/upload/voucher_image.png') }}" alt="">
                                            </div>
                                            <div class="voucher__item--left-name" style="font-size: 10px;">
                                                RADIUS Hoa Khô
                                            </div>
                                            <div class="_2t7jNq _3LWUvt"></div>
                                        </div>
                                        <div class="container__voucher-item--right">
                                            <div class="voucher-item--right-info">
                                                <div class="voucher-item--right-info-name text">
                                                    {{ $product_voucher->voucher_name }}
                                                </div>
                                                <div class="voucher-item--right-info-end-date">
                                                    HSD: {{ date('d/m/Y', strtotime($product_voucher->end_date)) }}
                                                </div>
                                            </div>
                                            <div class="voucher-item--right-btn">
                                                @php
                                                    $count_voucher = 0;
                                                @endphp
                                                @foreach ($storage_customer_voucher as $item)
                                                    @if ($item->voucher_id == $product_voucher->voucher_id)
                                                        @php
                                                            $count_voucher++;
                                                        @endphp
                                                    @endif
                                                @endforeach
                                                @if ($count_voucher > 0)
                                                    <a>Lưu</a>
                                                @else
                                                    <a class="btn_saved_voucher_{{ $product_voucher->voucher_id }}" style="display: none;">Lưu</a>
                                                    <button class="btn_save_voucher btn_save_voucher_{{ $product_voucher->voucher_id }}" data-id="{{ $product_voucher->voucher_id }}">Lưu</button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="shipping-info">
                            @if ($price_discount->percent_discount > 0)
                                <div class="biolife-countdown" data-datetime="{{ $price_discount->date_end_discount }}">
                                </div>
                            @endif
                            <div class="content_btn_buy_now" style="display: flex; justify-content:space-between;">
                                @if (Session::get('customer_id'))
                                    @foreach ($product_storage as $prod_qty)
                                        @if ($product->product_id == $prod_qty->product_id)
                                            @if ($prod_qty->total_quantity_product > 0)
                                                <div class="sub_content_btn_buy">
                                                    <a href="{{ URL::to('buy_now/' . $product->product_id) }}" data-id="{{ $product->product_id }}" class="btn btn-block btn-radius-color btn_buy_now">MUA NGAY</a>
                                                </div>
                                            @endif
                                        @endif
                                    @endforeach
                                @else
                                    <a href="{{ URL::to('login_client') }}" class="btn btn-block btn-radius-color btn_buy_now">MUA
                                        NGAY</a>
                                @endif

                                <div class="content_txt_ads">
                                    <p class="shipping-day">3-Ngày Trả Hàng</p>
                                    <p class="for-today">Đặt ngay hôm nay</p>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="action-form" style="border: 1px solid #0000000d;">
                        <div class="quantity-box">
                            <span class="title">Số lượng:</span>
                            <div class="qty-input">
                                <input type="number" class="val_quantity val_qty_{{ $product->product_id }}" value="1" data-max_value="20" data-min_value="1" data-step="1">
                                <a href="#" class="qty-btn btn-up btn_up_add_cart" style="right: 45px">
                                    <i class="fa fa-caret-up" aria-hidden="true"></i>
                                </a>
                                <a href="#" class="qty-btn btn-down btn_down_add_cart" style="right: 45px">
                                    <i class="fa fa-caret-down" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="buttons">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                @if (Session::get('customer_id'))
                                    <a href="#" class="btn add-to-cart-btn btn-block btn-sm add_cart_many add_cart_many_detail" data-id="{{ $product->product_id }}" style="margin-left: 0px">thêm vào giỏ hàng</a>
                                @else
                                    <a href="{{ URL::to('login_client') }}" class="btn add-to-cart-btn btn-block btn-sm" style="margin-left: 0px">thêm vào giỏ hàng</a>
                                @endif

                            </div>
                        </div>
                        {{-- <div class="row buttons">
                            <p class="pull-row">
                                <a href="#" class="btn wishlist-btn">wishlist</a>
                                <a href="#" class="btn compare-btn">compare</a>
                            </p>
                        </div> --}}
                        <div class="social-media">
                            <ul class="social-list">
                                <li><a href="#" class="social-link"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                                </li>
                                <li><a href="#" class="social-link"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                </li>
                                <li><a href="#" class="social-link"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
                                </li>
                                <li><a href="#" class="social-link"><i class="fa fa-share-alt" aria-hidden="true"></i></a>
                                </li>
                                <li><a href="#" class="social-link"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                                </li>
                            </ul>
                        </div>
                        <div class="acepted-payment-methods">
                            <ul class="payment-methods">
                                <li><img src="{{ asset('public/font_end/assets/images/card1.jpg') }}" alt="" width="51" height="36"></li>
                                <li><img src="{{ asset('public/font_end/assets/images/card2.jpg') }}" alt="" width="51" height="36"></li>
                                <li><img src="{{ asset('public/font_end/assets/images/card3.jpg') }}" alt="" width="51" height="36"></li>
                                <li><img src="{{ asset('public/font_end/assets/images/card4.jpg') }}" alt="" width="51" height="36"></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Tab info -->
                <div class="product-tabs single-layout biolife-tab-contain" style="margin-top: 20px;">
                    <div class="tab-head" style="background-color: #fff;">
                        <ul class="tabs" style="padding: 16px 0 16px 5px; border-bottom: 1px solid rgba(0, 0, 0, 0.09);">
                            <li class="tab-element active"><a href="#tab_1st" class="tab-link">Mô Tả Sản Phẩm</a>
                            </li>
                            <li class="tab-element"><a href="#tab_4th" class="tab-link">Đánh Giá Sản Phẩm <sup class="count_rating_tab">({{ count($all_rating_to_count) }})</sup></a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content cus_bg_product_detail_tab_content text-justify">
                        <div id="tab_1st" class="tab-contain desc-tab active" style="padding: 5px; padding-top: 0px; border-bottom: none;">
                            <p class="desc">{!! $product->product_desc !!}</p>
                        </div>
                        <div id="tab_4th" class="tab-contain review-tab">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">

                                        <div class="rating-info" style="padding-left: 5px;">
                                            <p class="index" style="font-size: 18px; font-weight: bold"><strong class="rating">{{ number_format($avg_rating, 1, '.', '.') }}</strong>trên
                                                5</p>
                                            <div class="rating">
                                                <p class="star-rating"><span class="width-80percent" style="width: {{ $avg_rating * 20 }}%"></span></p>
                                            </div>
                                            <div class="content-total-rating-comment" style="display: flex;">
                                                <p class="see-all count_rating_rating">{{ count($all_rating_to_count) }}
                                                    đánh giá </p>
                                                <p class="see-all count_comment_rating" style="padding-left: 5px"> |
                                                    {{ count($all_comment_to_count) }} bình luận</p>
                                            </div>

                                            <ul class="options">
                                                <li>
                                                    <div class="detail-for">
                                                        <span class="option-name">
                                                            5 <i class="fa fa-star-o" aria-hidden="true" style="color: #68645f; font-size: 16px"></i>
                                                        </span>
                                                        <span class="progres">
                                                            <span class="line-100percent"><span class="percent width-30percent" style="width: {{ $persen_rating_5 }}%"></span></span>
                                                        </span>
                                                        <span class="number">{{ $persen_rating_5 }}%</span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="detail-for">
                                                        <span class="option-name">
                                                            4 <i class="fa fa-star-o" aria-hidden="true" style="color: #68645f; font-size: 16px"></i>
                                                        </span>
                                                        <span class="progres">
                                                            <span class="line-100percent"><span class="percent width-30percent" style="width: {{ $persen_rating_4 }}%"></span></span>
                                                        </span>
                                                        <span class="number">{{ $persen_rating_4 }}%</span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="detail-for">
                                                        <span class="option-name">
                                                            3 <i class="fa fa-star-o" aria-hidden="true" style="color: #68645f; font-size: 16px"></i>
                                                        </span>
                                                        <span class="progres">
                                                            <span class="line-100percent"><span class="percent width-40percent" style="width: {{ $persen_rating_3 }}%"></span></span>
                                                        </span>
                                                        <span class="number">{{ $persen_rating_3 }}%</span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="detail-for">
                                                        <span class="option-name">
                                                            2 <i class="fa fa-star-o" aria-hidden="true" style="color: #68645f; font-size: 16px"></i>
                                                        </span>
                                                        <span class="progres">
                                                            <span class="line-100percent"><span class="percent width-20percent" style="width: {{ $persen_rating_2 }}%"></span></span>
                                                        </span>
                                                        <span class="number">{{ $persen_rating_2 }}%</span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="detail-for">
                                                        <span class="option-name">
                                                            1 <i class="fa fa-star-o" aria-hidden="true" style="color: #68645f; font-size: 16px"></i>
                                                        </span>
                                                        <span class="progres">
                                                            <span class="line-100percent"><span class="percent width-10percent" style="width: {{ $persen_rating_1 }}%"></span></span>
                                                        </span>
                                                        <span class="number">{{ $persen_rating_1 }}%</span>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-7 col-md-7 col-sm-6 col-xs-12">
                                        @if (Session::get('able_rating_comment_' . $product->product_id))
                                            <div class="review-form-wrapper">
                                                <span class="title">đánh giá sản phẩm</span>
                                                @if (!Session::get('rated_' . $product->product_id))
                                                    {{-- HIDDEN VAL NUM RATING --}}
                                                    <input type="hidden" value="" class="val_hidden_number_rating">
                                                    <div class="comment-form-rating hidden_rating">
                                                        <label>1. Bạn cảm thấy sản phẩm này như thế nào ?</label>
                                                        <p class="stars">
                                                            <span>
                                                                <a class="btn-rating choose_rating" data-value="1" href="#">
                                                                    <i class="fa fa-star-o" aria-hidden="true" style="font-size: 18px"></i>
                                                                </a>
                                                                <a class="btn-rating choose_rating" data-value="2" href="#">
                                                                    <i class="fa fa-star-o" aria-hidden="true" style="font-size: 18px"></i>
                                                                </a>
                                                                <a class="btn-rating choose_rating" data-value="3" href="#">
                                                                    <i class="fa fa-star-o" aria-hidden="true" style="font-size: 18px"></i>
                                                                </a>
                                                                <a class="btn-rating choose_rating" data-value="4" href="#">
                                                                    <i class="fa fa-star-o" aria-hidden="true" style="font-size: 18px"></i>
                                                                </a>
                                                                <a class="btn-rating choose_rating" data-value="5" href="#">
                                                                    <i class="fa fa-star-o" aria-hidden="true" style="font-size: 18px"></i>
                                                                </a>
                                                            </span>
                                                        </p>
                                                    </div>
                                                @else
                                                    <input type="hidden" value="{{ Session::get('rated_' . $product->product_id) }}" class="val_hidden_number_rating">
                                                @endif
                                                <p class="form-row">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                    <textarea name="comment" class="comment_message" id="txt_comment" cols="30" rows="10" style="max-width: 500px;" placeholder="Viết đánh giá của bạn về sản phẩm này..."></textarea>
                                                </p>
                                                <p class="form-row">
                                                    <button type="submit" name="submit" class="send_comment_rating">Gửi đánh
                                                        giá</button>
                                                </p>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                                <div id="comments">
                                    <ol class="commentlist content_comment_rating">
                                        @if (count($all_comment) > 0)
                                            @foreach ($all_comment as $comment)
                                                @if ($comment->status == 0 && $comment->customer_id == Session::get('customer_id'))
                                                    <li class="review" style="margin-right: 16px; margin-left: -16px; opacity: .8;background-color:#f5f5f5;">
                                                        <div class="comment-container" style="padding-left: 20px">
                                                            <div class="row">
                                                                <div class="comment-content col-lg-8 col-md-9 col-sm-8 col-xs-12">
                                                                    <div class="content_info_customer">
                                                                        @foreach ($customers as $customer)
                                                                            @if ($comment->customer_id == $customer->customer_id)
                                                                                <img src="{{ asset('public/upload/' . $customer->customer_avt) }}" style="width: 60px; height: 60px; border-radius: 50%" alt="">
                                                                                <div class="content-name-rating">
                                                                                    <p class="comment-in"><span class="post-name">{{ $customer->username }}</span>
                                                                                    </p>
                                                                                    <div class="rating">
                                                                                        <p class="star-rating">
                                                                                            @php
                                                                                                $convert_persen = 0;
                                                                                            @endphp
                                                                                            @foreach ($all_rating as $rating)
                                                                                                @if ($rating->customer_id == $customer->customer_id)
                                                                                                    @php
                                                                                                        $rating_level = $rating->rating_level;
                                                                                                    @endphp
                                                                                                @break
                                                                                            @else
                                                                                                @php
                                                                                                    $rating_level = 0;
                                                                                                @endphp
                                                                                            @endif
                                                                            @endforeach
                                                                            @if ($rating_level == 1)
                                                                                @php
                                                                                    $convert_persen = 20;
                                                                                @endphp
                                                                            @elseif($rating_level == 2)
                                                                                @php
                                                                                    $convert_persen = 40;
                                                                                @endphp
                                                                            @elseif($rating_level == 3)
                                                                                @php
                                                                                    $convert_persen = 60;
                                                                                @endphp
                                                                            @elseif($rating_level == 4)
                                                                                @php
                                                                                    $convert_persen = 80;
                                                                                @endphp
                                                                            @elseif($rating_level == 5)
                                                                                @php
                                                                                    $convert_persen = 100;
                                                                                @endphp
                                                                            @endif
                                                                            <span class="width-{{ $convert_persen }}percent"></span>
                                                                            </p>
                                                                    </div>
                                                                </div>
                                                @endif
                                            @endforeach
                                            <span class="post-date date-comment">{{ date('d/m/Y H:i a', strtotime($comment->created_at)) }}</span>
                                            @if (Session::get('customer_id') == $comment->customer_id)
                                                <div class="option_comment">
                                                    <div class="dropdown_option_comment">
                                                        <i class="fa fa-ellipsis-h dot" style="cursor: pointer;"></i>
                                                        <div class="dropdown_content_option_comment">
                                                            <a class="btn_open_modal_delete_comment btn_delete_comment" style="cursor: pointer;" data-id="{{ $comment->comment_id }}">
                                                                <i class="fa fa-trash-o" aria-hidden="true"></i> xóa
                                                            </a>
                                                            @if (Session::get('customer_id') == $comment->customer_id && $comment->status == 0)
                                                                <a style="cursor: pointer;" class="btn_update_comment" data-id="{{ $comment->comment_id }}">
                                                                    <i class="fa fa-pencil" aria-hidden="true"></i> sửa
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            {{-- </p> --}}
                                </div>

                                <p class="author place_order" style="margin-left: 70px"><i class="fa fa-check-circle" style="color: var(--radius-color)"></i> đã mua tại <b class="brand_mku">RADIUS Hoa Khô</b></p>
                                <p class="comment-text comment_message comment_message_{{ $comment->comment_id }}" style="font-size: 15px">{{ $comment->comment_message }}</p>
                                <div class="content_area_update_comment content_area_update_comment_{{ $comment->comment_id }}">
                                    <textarea class="area_update_comment area_update_comment_{{ $comment->comment_id }}" style="padding: 2px 5px ">{{ $comment->comment_message }}</textarea>
                                    <div class="content_btn_update_comment">
                                        <button class="btn btn-secondary btn_huy_update_comment" data-id="{{ $comment->comment_id }}">Hủy</button>
                                        <button class="btn btn-success btn_confirm_update_comment" data-id="{{ $comment->comment_id }}">Sửa</button>
                                    </div>
                                </div>
                            </div>
                            <div class="comment-review-form col-lg-3 col-lg-offset-1 col-md-3 col-sm-4 col-xs-12">
                                <span class="title">Đánh giá này có hữu ích?</span>
                                <ul class="actions">
                                    @php
                                        $session = Session::get('user_like_comment_' . $comment->comment_id);
                                    @endphp
                                    @if (isset($session))
                                        <li>
                                            <a class="btn-act like btn_useful_comment btn_useful_comment_{{ $comment->comment_id }}" style="color: var(--radius-color); cursor: pointer;" data-id="{{ $comment->comment_id }}">
                                                <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                                                <span class="txt_count_comment_useful_{{ $comment->comment_id }}">Hữu ích
                                                    ({{ $comment->comment_useful }})</span>
                                            </a>
                                        </li>
                                        <h4 class="announce_waiting_comment">
                                            Bình luận của bạn đang chờ xét duyệt
                                        </h4>
                                        <input type="hidden" class="hidden_check_comment_like_{{ $comment->comment_id }}" name="" id="" value="{{ $session }}">
                                    @else
                                        <li>
                                            <a class="btn-act like btn_useful_comment btn_useful_comment_{{ $comment->comment_id }}" style="cursor: pointer;" data-id="{{ $comment->comment_id }}">
                                                <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                                                <span class="txt_count_comment_useful_{{ $comment->comment_id }}">Hữu ích
                                                    ({{ $comment->comment_useful }})</span>
                                            </a>
                                        </li>
                                        <h4 class="announce_waiting_comment">
                                            Bình luận của bạn đang chờ xét duyệt
                                        </h4>
                                        <input type="hidden" class="hidden_check_comment_like_{{ $comment->comment_id }}" name="" id="" value="{{ $session }}">
                                    @endif

                                </ul>
                            </div>

                        </div>
                    </div>
                    </li>
                @elseif($comment->status == 1)
                    <li class="review" style="margin-right: 16px; margin-left: -16px">
                        <div class="comment-container" style="padding-left: 20px">
                            <div class="row">
                                <div class="comment-content col-lg-8 col-md-9 col-sm-8 col-xs-12">
                                    <div class="content_info_customer">
                                        @foreach ($customers as $customer)
                                            @if ($comment->customer_id == $customer->customer_id)
                                                <img src="{{ asset('public/upload/' . $customer->customer_avt) }}" style="width: 60px; height: 60px; border-radius: 50%" alt="">
                                                <div class="content-name-rating">
                                                    <p class="comment-in"><span class="post-name">{{ $customer->username }}</span></p>
                                                    <div class="rating">
                                                        <p class="star-rating">
                                                            @php
                                                                $convert_persen = 0;
                                                            @endphp
                                                            @foreach ($all_rating as $rating)
                                                                @if ($rating->customer_id == $customer->customer_id)
                                                                    @php
                                                                        $rating_level = $rating->rating_level;
                                                                    @endphp
                                                                @break
                                                            @else
                                                                @php
                                                                    $rating_level = 0;
                                                                @endphp
                                                            @endif
                                            @endforeach
                                            @if ($rating_level == 1)
                                                @php
                                                    $convert_persen = 20;
                                                @endphp
                                            @elseif($rating_level == 2)
                                                @php
                                                    $convert_persen = 40;
                                                @endphp
                                            @elseif($rating_level == 3)
                                                @php
                                                    $convert_persen = 60;
                                                @endphp
                                            @elseif($rating_level == 4)
                                                @php
                                                    $convert_persen = 80;
                                                @endphp
                                            @elseif($rating_level == 5)
                                                @php
                                                    $convert_persen = 100;
                                                @endphp
                                            @endif
                                            <span class="width-{{ $convert_persen }}percent"></span>
                                            </p>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                                <span class="post-date date-comment">{{ date('d/m/Y H:i a', strtotime($comment->created_at)) }}</span>
                                @if (Session::get('customer_id') == $comment->customer_id)
                                    <div class="option_comment">
                                        <div class="dropdown_option_comment">
                                            <i class="fa fa-ellipsis-h dot" style="cursor: pointer;"></i>
                                            <div class="dropdown_content_option_comment">
                                                <a class="btn_open_modal_delete_comment btn_delete_comment" style="cursor: pointer;" data-id="{{ $comment->comment_id }}">
                                                    <i class="fa fa-trash-o" aria-hidden="true"></i> xóa
                                                </a>
                                                @if (Session::get('customer_id') == $comment->customer_id && $comment->status == 0)
                                                    <a style="cursor: pointer;" class="btn_update_comment" data-id="{{ $comment->comment_id }}">
                                                        <i class="fa fa-pencil" aria-hidden="true"></i> sửa
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                {{-- </p> --}}
                            </div>

                            <p class="author place_order laptop" style="margin-left: 70px">
                                <i class="fa fa-check-circle" style="color: var(--radius-color);"></i>
                                đã mua tại <b class="brand_mku">RADIUS Hoa Khô</b>
                            </p>
                            <p class="comment-text comment_message comment_message_{{ $comment->comment_id }}" style="font-size: 15px">{{ $comment->comment_message }}</p>
                            <div class="content_area_update_comment content_area_update_comment_{{ $comment->comment_id }}">
                                <textarea class="area_update_comment area_update_comment_{{ $comment->comment_id }}" style="padding: 2px 5px ">{{ $comment->comment_message }}</textarea>
                                <div class="content_btn_update_comment">
                                    <button class="btn btn-secondary btn_huy_update_comment" data-id="{{ $comment->comment_id }}">Hủy</button>
                                    <button class="btn btn-success btn_confirm_update_comment" data-id="{{ $comment->comment_id }}">Sửa</button>
                                </div>
                            </div>
                        </div>
                        <div class="comment-review-form col-lg-3 col-lg-offset-1 col-md-3 col-sm-4 col-xs-12">
                            <span class="title">Đánh giá này có hữu ích?</span>
                            <ul class="actions">
                                @php
                                    $session = Session::get('user_like_comment_' . $comment->comment_id);
                                @endphp
                                @if (isset($session))
                                    <li><a class="btn-act like btn_useful_comment btn_useful_comment_{{ $comment->comment_id }}" style="color: var(--radius-color); cursor: pointer;" data-id="{{ $comment->comment_id }}">
                                            <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                                            <span class="txt_count_comment_useful_{{ $comment->comment_id }}">Hữu ích
                                                ({{ $comment->comment_useful }})</span>
                                        </a></li>
                                    <input type="hidden" class="hidden_check_comment_like_{{ $comment->comment_id }}" name="" id="" value="{{ $session }}">
                                @else
                                    <li><a class="btn-act like btn_useful_comment btn_useful_comment_{{ $comment->comment_id }}" style="cursor: pointer;" data-id="{{ $comment->comment_id }}">
                                            <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                                            <span class="txt_count_comment_useful_{{ $comment->comment_id }}">Hữu ích
                                                ({{ $comment->comment_useful }})</span>
                                        </a></li>
                                    <input type="hidden" class="hidden_check_comment_like_{{ $comment->comment_id }}" name="" id="" value="{{ $session }}">
                                @endif

                            </ul>
                        </div>

                </div>
            </div>
            </li>
            @endif
            @endforeach
        @else
            <div class="center pd-20" style="font-size: 18px;padding-top: 30px; opacity: .5;">Sản phẩm chưa có đánh giá nào
            </div>
            @endif
            </ol>
            <input type="hidden" value="{{ $product->product_id }}" class="val_product_id">
            <input type="hidden" value="{{ count($all_comment_to_count) }}" class="all_comment_to_count">
            <input type="hidden" value="{{ count($all_rating_to_count) }}" class="all_rating_to_count">
            <input type="hidden" value="5" class="val_load_add_5">
            @if ($check_show > 0)
                <div class="biolife-panigations-block version-2">
                    <ul class="panigation-contain">
                    </ul>
                    <div class="result-count" style="text-align: center">
                        <a class="link-to load_more_comment" style="cursor: pointer; font-size: 17px"><u>Xem Thêm</u></a>
                    </div>
                </div>
            @else
        </div>
        @endif
    </div>
    </div>
    </div>
    </div>
    {{-- realative product --}}
    <div class="product-related-box single-layout">
        @php
            $count = 0;
        @endphp
        @foreach ($all_product_relate as $product_relate)
            @if ($product_relate->category_id == $product->category_id && $product_relate->product_id != $product->product_id)
                @php
                    $count++;
                @endphp
            @endif
        @endforeach
        @if ($count > 0)
            {{-- laptop --}}
            <div class="laptop">
                <div class="row">
                    <div id="main-content" class="main-content col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="block-item head__title" style="margin-top: -25px;">
                            <div class="head__title--text">
                                Sản Phẩm Liên Quan
                            </div>
                        </div>
                    </div>
                </div>
                <div id="main-content" class="main-content col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <ul class="products-list biolife-carousel nav-center-02 nav-none-on-mobile"
                        data-slick='{"rows":1,"arrows":true,"dots":false,"infinite":false,"speed":400,"slidesMargin":0,"slidesToShow":5, "responsive":[{"breakpoint":1200, "settings":{ "slidesToShow": 3}},{"breakpoint":992, "settings":{ "slidesToShow": 3, "slidesMargin":30}},{"breakpoint":768, "settings":{ "slidesToShow": 2, "slidesMargin":10}}]}'>
                        @foreach ($all_product_relate as $product_relate)
                            @php
                                $price_discount = App\Http\Controllers\HomeClientController::check_price_discount($product_relate->product_id);
                                $info_rating_saled = App\Http\Controllers\HomeClientController::info_rating_saled($product_relate->product_id);
                                $check_already_wish = App\Http\Controllers\WishListController::checkProductWishLish($product_relate->product_id);
                            @endphp
                            @if ($product_relate->category_id == $product->category_id && $product_relate->product_id != $product->product_id)
                                <li class="product-item col-lg-4 col-md-4 col-sm-4 col-xs-6">
                                    <div class="contain-product layout-default content_product_sm">
                                        <div class="product-thumb">
                                            <form>
                                                @csrf
                                                <input type="hidden" value="{{ $product_relate->product_name }}" id="recently_viewed_product_name_{{ $product_relate->product_id }}">
                                                <input type="hidden" value="{{ number_format($price_discount->price_now, 0, ',', '.') }}₫" id="recently_viewed_product_price_{{ $product_relate->product_id }}">
                                            </form>
                                            <a href="{{ URL::to('product_detail_slug/' . $product_relate->slug) }}" class="link-to-product btn_recently_viewed" data-id="{{ $product_relate->product_id }}"
                                                id="recently_viewed_product_detail_{{ $product_relate->product_id }}">
                                                <img src="{{ asset('public/upload/' . $product_relate->product_image) }}" alt="dd" style="width: 220px; height: 220px" class="product-thumnail"
                                                    id="recently_viewed_product_img_{{ $product_relate->product_id }}">
                                            </a>
                                            <span href="#" class="lookup get_val_quickview btn_call_quickview_detail btn_open_modal" data-id="{{ $product_relate->product_id }}"><i class="biolife-icon icon-search"></i></span>
                                        </div>
                                        <div class="info">
                                            <h4 class="product-title">
                                                <a href="{{ URL::to('product_detail_slug/' . $product_relate->slug) }}" class="pr-name name_product cus_prod_name_card_sm btn_recently_viewed" data-id="{{ $product_relate->product_id }}">
                                                    {{ $product_relate->product_name }}
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
                                                <div class="availeble_product">Đã bán:
                                                    {{ $info_rating_saled->count_product_saled }}</div>
                                            </div>
                                            <div class="slide-down-box">
                                                <div class="buttons" style="padding: 0px;">
                                                    {{-- wish list --}}
                                                    @if (Session::get('customer_id'))
                                                        <a class="btn wishlist-btn btn_add_wish_lish" style="cursor: pointer;" data-id="{{ $product_relate->product_id }}">
                                                            @if ($check_already_wish->check_already == 1)
                                                                <i class="fa fa-heart" aria-hidden="true" style="color: #eb7e82;"></i>
                                                            @else
                                                                <i class="fa fa-heart icon_wish_list_{{ $product_relate->product_id }}" aria-hidden="true"></i>
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
                                                        <button href="#" class="btn add-to-cart-btn btn-block btn-sm add_cart_one" data-id="{{ $product_relate->product_id }}" style="font-size: 12px;"><i class="fa fa-cart-arrow-down"
                                                                aria-hidden="true"></i>
                                                            thêm vào giỏ hàng
                                                        </button>
                                                    @else
                                                        <a href="{{ URL::to('login_client') }}" class="btn add-to-cart-btn btn-block btn-sm" style="font-size: 12px;"><i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                                                            thêm vào giỏ hàng
                                                        </a>
                                                    @endif
                                                    {{-- add cart --}}
                                                    <input type="hidden" class="val_qty_{{ $product_relate->product_id }}" value="1">
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
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
            {{-- responsive mobile --}}
            <div class="mobile">
                @include('client.layout.responsive_mobile.view_ralative_product')
            </div>
        @endif

    </div>
    </div>
    </div>
    </div>
    <!-- The Modal -->
    <div class="modal_delete_comment modal">
        <!-- Modal content -->
        <div class="modal-content container" style="width: 40%">
            <div class="modal-header-cus modal-header-delete_comment">
                <span class="close close_modal_delete_comment">&times;</span>
                <h4 style="font-size: 20px">Thông Báo</h4>
            </div>
            <div class="modal-body-cus" style="background: #f8f8f8">
                <form>
                    @csrf
                    <div class="">Bạn muốn xóa đánh giá này ?</div>
                    <input type="hidden" value="" class="val_hidden_comment_to_delete">
                </form>
            </div>
            <div class="content-modal-footer-address">
                <button class="btn btn-success btn_confirm_delete_comment" style="margin-right: 10px">Xóa</button>
                <button class="btn btn-secondary btn_back_modal_address">Hủy</button>
            </div>
        </div>
    </div>
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
    <script src="{{ asset('public/font_end/custom/sweet.js') }}"></script>
    <script src="{{ asset('public/font_end/custom/save_voucher.js') }}"></script>
    <script src="{{ asset('public/font_end/custom/rating_comment.js') }}"></script>
    <script src="{{ asset('public/font_end/custom/mini_detail_product.js') }}"></script>
    <script src="{{ asset('public/font_end/custom_ui/js/recently_viewed.js') }}"></script>

    {{-- <script src="{{ asset('public/font_end/assets/js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('public/font_end/custom/custom.js') }}"></script>
    <script src="{{ asset('public/font_end/custom/update_cart_ajax.js') }}"></script>
    <script src="{{ asset('public/font_end/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/font_end/custom/mini_detail_product.js') }}"></script>
    <script src="{{ asset('public/font_end/custom_ui/js/ajax_wish_list.js') }}"></script> --}}

@endsection
