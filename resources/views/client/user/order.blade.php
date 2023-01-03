<link rel="stylesheet" href="{{ asset('public/font_end/custom_account/user_sidebar_content.css') }}">
<link rel="stylesheet" href="{{ asset('public/font_end/responsive/mobile.css') }}">
@extends('client.layout_account_client')
@section('content_body')
    <link rel="stylesheet" href="{{ asset('public/font_end/custom_account/custom_modal.css') }}">
    <style>
        .btn:focus,
        .btn:active:focus,
        .btn.active:focus,
        .btn.focus,
        .btn:active.focus,
        .btn.active.focus {
            outline: none;
        }

        a h5 {
            padding-left: 10px;
        }

        .content-item-body .content-item-quantity {
            padding-left: 10px;
        }

    </style>
    <div class="container laptop">
        <nav class="biolife-nav cus_breadcrumb">
            <ul>
                <li class="nav-item"><a href="{{ URL::to('/') }}" class="permal-link">Trang chủ</a></li>
                <li class="nav-item"><a href="{{ URL::to('user/account') }}" class="permal-link">Tài khoản</a></li>
                <li class="nav-item"><span class="current-page">Hồ sơ</span></li>
            </ul>
        </nav>
    </div>
    <div class="page-contain">
        <!-- Main content -->
        <div id="main-content" class="main-content">
            <div class="container">
                <div class="row">
                    <!--sidebar-->
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <nav class="user">
                            <div class="user-heading">
                                @if (Session::get('customer_id'))
                                    <img src="{{ asset('public/upload/' . $customer_info->customer_avt) }}" alt="" class="user-img">
                                @else
                                    <img src="{{ asset('public/upload/no_image.png') }}" alt="" class="user-img">
                                @endif

                                @if (Session::get('customer_id'))
                                    <span class="user-name">{{ $customer->username }}</span>
                                @else
                                    <span class="user-name">Unknown</span>
                                @endif
                            </div>
                            <div class="laptop">
                                <ul class="user-list-module">
                                    <li class="user-module-item">
                                        <a href="{{ URL::to('user/account') }}" class="user-module-item--link">Hồ sơ</a>
                                    </li>
                                    <li class="user-module-item">
                                        <a href="{{ URL::to('user/address') }}" class="user-module-item--link">Địa chỉ</a>
                                    </li>
                                    <li class="user-module-item">
                                        <a href="{{ URL::to('user/resetpassword') }}" class="user-module-item--link">Đổi mật
                                            khẩu</a>
                                    </li>
                                    <li class="user-module-item user-module-item--active">
                                        <a href="{{ URL::to('user/order') }}" class="user-module-item--link">Đơn mua</a>
                                    </li>
                                    <li class="user-module-item">
                                        <a href="{{ URL::to('user/voucher') }}" class="user-module-item--link">Kho
                                            Voucher</a>
                                    </li>
                                </ul>
                            </div>
                            {{-- responsive mobile --}}
                            <div class="mobile">
                                <div class="content-nav-account" style="display: flex; justify-content: space-between; padding: 5px 0px 10px 0px">
                                    <a href="{{ URL::to('user/account') }}" class="cus_btn">Hồ sơ</a>
                                    <a href="{{ URL::to('user/address') }}" class="cus_btn">Địa chỉ</a>
                                    <a href="{{ URL::to('user/order') }}" class="cus_btn active_account">Đơn mua</a>
                                    <a href="{{ URL::to('user/voucher') }}" class="cus_btn">Kho voucher</a>
                                </div>
                            </div>
                        </nav>
                    </div>
                    <!--content-user-->
                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12" style="display: flex; margin-bottom: 32px;">
                        <div class="content__user-order">
                            <div class="tabs">
                                <input type="radio" class="tabs__radio" name="tabs-example" id="tab1" checked>
                                <label for="tab1" class="tabs__label">Tất cả</label>
                                <div class="tabs__content">
                                    @if (count($all_order) > 0)
                                        @foreach ($all_order as $order)
                                            <div class="tab__content-item">
                                                <div class="heading-item">
                                                    @foreach ($all_order_detail_status as $status_order_detail)
                                                        @if ($status_order_detail->order_id == $order->order_id)
                                                            @foreach ($status_order as $status)
                                                                @if ($status->status_id == $status_order_detail->status_id && $status_order_detail->status == 1)
                                                                    @if ($status_order_detail->status_id == 5)
                                                                        <span class="heading-item-status-cancel">{{ $status->status_name }}</span>
                                                                    @else
                                                                        <span class="heading-item-status">{{ $status->status_name }}</span>
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                </div>
                                                <ul class="content-item-list">
                                                    @foreach ($all_order_item as $order_item)
                                                        @if ($order_item->order_id == $order->order_id)
                                                            <a href="#" class="content-item-link">
                                                                <li class="content-item">
                                                                    @foreach ($all_product as $product)
                                                                        @if ($product->product_id == $order_item->product_id)
                                                                            <a href="{{ URL::to('product_detail_slug/' . $product->slug) }}"><img src="{{ asset('public/upload/' . $product->product_image) }}" alt="" class="content-item-img"></a>
                                                                        @endif
                                                                    @endforeach
                                                                    <div class="content-item-info">
                                                                        <div class="content-item-head">
                                                                            @foreach ($all_product as $product)
                                                                                @if ($order_item->product_id == $product->product_id)
                                                                                    <a href="{{ URL::to('product_detail_slug/' . $product->slug) }}">
                                                                                        <h5 class="content-item-name">
                                                                                            {{ $product->product_name }}
                                                                                        </h5>
                                                                                    </a>
                                                                                @endif
                                                                            @endforeach
                                                                            <div class="content-item-price-wrap">
                                                                                <span class="content-item-price">{{ number_format($order_item->quantity_product * $order_item->price_product, 0, '', '.') }}₫</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="content-item-body">
                                                                            <span class="content-item-quantity">Số lượng x
                                                                                {{ $order_item->quantity_product }}</span>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </a>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                                <footer class="content-item-footer">
                                                    <span class="content-item-total">Tổng tiền:
                                                        {{ number_format($order->total_price, 0, '.', ',') }}₫</span>
                                                </footer>
                                                <footer class="content-btn-footer">
                                                    @foreach ($all_order_detail_status as $status_order_detail)
                                                        @if ($status_order_detail->order_id == $order->order_id)
                                                            @if (($status_order_detail->status_id == 1 && $status_order_detail->status == 1) || ($status_order_detail->status_id == 2 && $status_order_detail->status == 1))
                                                                <a href="{{ URL::to('user/order/' . $order->order_id) }}" class="item-btn-footer-primary">Xem chi tiết đơn
                                                                    hàng</a>
                                                                <button class="item-btn-footer delete_order get_order_id btn_open_order_cancel" data-id={{ $order->order_id }}>Hủy đơn hàng</button>
                                                            @elseif($status_order_detail->status_id == 5 &&
                                                                $status_order_detail->status == 1)
                                                                <button class="item-btn-footer-primary--disable">Xem chi
                                                                    tiết đơn hàng</button>
                                                            @elseif($status_order_detail->status == 1)
                                                                <a href="{{ URL::to('user/order/' . $order->order_id) }}" class="item-btn-footer-primary">Xem chi tiết đơn
                                                                    hàng</a>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                </footer>
                                            </div>
                                        @endforeach
                                    @else

                                        <div class="tab__content-item">
                                            <div class="content-item-empty">
                                                <img src="{{ asset('public/upload/empty.png') }}" width="200" height="200" alt="">
                                                <span class="content-item-empty-text">Hiện không có đơn hàng nào</span>
                                            </div>
                                        </div>

                                    @endif

                                </div>

                                <input type="radio" class="tabs__radio" name="tabs-example" id="tab2">
                                <label for="tab2" class="tabs__label">Chờ xác nhận</label>
                                <div class="tabs__content">

                                    @if (count($order_confirm) > 0)
                                        @foreach ($all_order as $order)
                                            @foreach ($order_confirm as $status_order_detail)
                                                @if ($status_order_detail->status_id == 1 && $status_order_detail->order_id == $order->order_id)
                                                    <div class="tab__content-item">
                                                        <div class="heading-item">
                                                            @foreach ($status_order as $status)
                                                                @if ($status->status_id == 1)
                                                                    <span class="heading-item-status">{{ $status->status_name }}</span>
                                                                @endif
                                                            @endforeach
                                                        </div>

                                                        <ul class="content-item-list">

                                                            @foreach ($all_order_item as $order_item)
                                                                @if ($order_item->order_id == $order->order_id)

                                                                    <a href="#" class="content-item-link">
                                                                        <li class="content-item">
                                                                            @foreach ($all_product as $product)
                                                                                @if ($product->product_id == $order_item->product_id)
                                                                                    <a href="{{ URL::to('product_detail_slug/' . $product->slug) }}">
                                                                                        <img src="{{ asset('public/upload/' . $product->product_image) }}" alt="" class="content-item-img">
                                                                                    </a>
                                                                                @endif
                                                                            @endforeach
                                                                            <div class="content-item-info">
                                                                                <div class="content-item-head">
                                                                                    @foreach ($all_product as $product)
                                                                                        @if ($order_item->product_id == $product->product_id)
                                                                                            <a href="{{ URL::to('product_detail_slug/' . $product->slug) }}">
                                                                                                <h5 class="content-item-name">
                                                                                                    {{ $product->product_name }}
                                                                                                </h5>
                                                                                            </a>
                                                                                        @endif
                                                                                    @endforeach

                                                                                    <div class="content-item-price-wrap">
                                                                                        <span class="content-item-price">{{ number_format($order_item->quantity_product * $order_item->price_product, 0, '', ',') }}₫</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="content-item-body">
                                                                                    <span class="content-item-quantity">Số
                                                                                        lượng x
                                                                                        {{ $order_item->quantity_product }}</span>
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                    </a>

                                                                @endif
                                                            @endforeach

                                                        </ul>
                                                        <footer class="content-item-footer">
                                                            <span class="content-item-total">Tổng tiền:
                                                                {{ number_format($order->total_price, 0, '.', ',') }}₫</span>
                                                        </footer>
                                                        <footer class="content-btn-footer">
                                                            <a href="{{ URL::to('user/order/' . $order->order_id) }}" class="item-btn-footer-primary">Xem chi tiết đơn hàng</a>
                                                            <button class="item-btn-footer delete_order get_order_id btn_open_order_cancel" data-id={{ $order->order_id }}>Hủy đơn hàng</button>
                                                        </footer>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endforeach

                                    @else
                                        <div class="tab__content-item">
                                            <div class="content-item-empty">
                                                <img src="{{ asset('public/upload/empty.png') }}" width="200" height="200" alt="">
                                                <span class="content-item-empty-text">Hiện không có đơn hàng nào đang chờ
                                                    xác nhận</span>
                                            </div>
                                        </div>
                                    @endif

                                </div>

                                <input type="radio" class="tabs__radio" name="tabs-example" id="tab3">
                                <label for="tab3" class="tabs__label">Đã xác nhận</label>
                                <div class="tabs__content">

                                    @if (count($order_confirmed) > 0)
                                        @foreach ($all_order as $order)
                                            @foreach ($order_confirmed as $status_order_detail)
                                                @if ($status_order_detail->status_id == 2 && $status_order_detail->order_id == $order->order_id)
                                                    <div class="tab__content-item">
                                                        <div class="heading-item">
                                                            @foreach ($status_order as $status)
                                                                @if ($status->status_id == 2)
                                                                    <span class="heading-item-status">{{ $status->status_name }}</span>
                                                                @endif
                                                            @endforeach
                                                        </div>

                                                        <ul class="content-item-list">

                                                            @foreach ($all_order_item as $order_item)
                                                                @if ($order_item->order_id == $order->order_id)

                                                                    <a href="#" class="content-item-link">
                                                                        <li class="content-item">
                                                                            @foreach ($all_product as $product)
                                                                                @if ($product->product_id == $order_item->product_id)
                                                                                    <a href="{{ URL::to('product_detail_slug/' . $product->slug) }}">
                                                                                        <img src="{{ asset('public/upload/' . $product->product_image) }}" alt="" class="content-item-img">
                                                                                    </a>
                                                                                @endif
                                                                            @endforeach
                                                                            <div class="content-item-info">
                                                                                <div class="content-item-head">
                                                                                    @foreach ($all_product as $product)
                                                                                        @if ($order_item->product_id == $product->product_id)
                                                                                            <a href="{{ URL::to('product_detail_slug/' . $product->slug) }}">
                                                                                                <h5 class="content-item-name">
                                                                                                    {{ $product->product_name }}
                                                                                                </h5>
                                                                                            </a>
                                                                                        @endif
                                                                                    @endforeach

                                                                                    <div class="content-item-price-wrap">
                                                                                        <span class="content-item-price">{{ number_format($order_item->quantity_product * $order_item->price_product, 0, '', ',') }}₫</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="content-item-body">
                                                                                    <span class="content-item-quantity get_quantity_">Số
                                                                                        lượng x
                                                                                        {{ $order_item->quantity_product }}</span>
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                    </a>

                                                                @endif
                                                            @endforeach

                                                        </ul>
                                                        <footer class="content-item-footer">
                                                            <span class="content-item-total">Tổng tiền:
                                                                {{ number_format($order->total_price, 0, '.', ',') }}₫</span>
                                                        </footer>
                                                        <footer class="content-btn-footer">
                                                            <a href="{{ URL::to('user/order/' . $order->order_id) }}" class="item-btn-footer-primary">Xem chi tiết đơn hàng</a>
                                                            <button class="item-btn-footer delete_order get_order_id btn_open_order_cancel" data-id={{ $order->order_id }}>Hủy đơn hàng</button>
                                                        </footer>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endforeach

                                    @else
                                        <div class="tab__content-item">
                                            <div class="content-item-empty">
                                                <img src="{{ asset('public/upload/empty.png') }}" width="200" height="200" alt="">
                                                <span class="content-item-empty-text">Hiện không có đơn hàng nào đã xác nhận</span>
                                            </div>
                                        </div>
                                    @endif

                                </div>

                                <input type="radio" class="tabs__radio" name="tabs-example" id="tab4">
                                <label for="tab4" class="tabs__label">Đang giao</label>
                                <div class="tabs__content">

                                    @if (count($order_delivering) > 0)

                                        @foreach ($all_order as $order)
                                            @foreach ($order_delivering as $status_order_detail)
                                                @if ($status_order_detail->status_id == 3 && $status_order_detail->order_id == $order->order_id)
                                                    <div class="tab__content-item">
                                                        <div class="heading-item">
                                                            @foreach ($status_order as $status)
                                                                @if ($status->status_id == 3)
                                                                    <span class="heading-item-status">{{ $status->status_name }}</span>
                                                                @endif
                                                            @endforeach
                                                        </div>

                                                        <ul class="content-item-list">

                                                            @foreach ($all_order_item as $order_item)
                                                                @if ($order_item->order_id == $order->order_id)

                                                                    <a href="#" class="content-item-link">
                                                                        <li class="content-item">
                                                                            @foreach ($all_product as $product)
                                                                                @if ($product->product_id == $order_item->product_id)
                                                                                    <a href="{{ URL::to('product_detail_slug/' . $product->slug) }}">
                                                                                        <img src="{{ asset('public/upload/' . $product->product_image) }}" alt="" class="content-item-img">
                                                                                    </a>
                                                                                @endif
                                                                            @endforeach
                                                                            <div class="content-item-info">
                                                                                <div class="content-item-head">
                                                                                    @foreach ($all_product as $product)
                                                                                        @if ($order_item->product_id == $product->product_id)
                                                                                            <a href="{{ URL::to('product_detail_slug/' . $product->slug) }}">
                                                                                                <h5 class="content-item-name">
                                                                                                    {{ $product->product_name }}
                                                                                                </h5>
                                                                                            </a>
                                                                                        @endif
                                                                                    @endforeach

                                                                                    <div class="content-item-price-wrap">
                                                                                        <span class="content-item-price">{{ number_format($order_item->quantity_product * $order_item->price_product, 0, '', ',') }}₫</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="content-item-body">
                                                                                    <span class="content-item-quantity">Số
                                                                                        lượng x
                                                                                        {{ $order_item->quantity_product }}</span>
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                    </a>

                                                                @endif
                                                            @endforeach

                                                        </ul>
                                                        <footer class="content-item-footer">
                                                            <span class="content-item-total">Tổng tiền:
                                                                {{ number_format($order->total_price, 0, '.', ',') }}₫</span>
                                                        </footer>
                                                        <footer class="content-btn-footer">
                                                            <a href="{{ URL::to('user/order/' . $order->order_id) }}" class="item-btn-footer-primary">Xem chi tiết đơn hàng</a>
                                                        </footer>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endforeach

                                    @else
                                        <div class="tab__content-item">
                                            <div class="content-item-empty">
                                                <img src="{{ asset('public/upload/empty.png') }}" width="200" height="200" alt="">
                                                <span class="content-item-empty-text">Hiện không có đơn hàng nào đang giao</span>
                                            </div>
                                        </div>
                                    @endif

                                </div>

                                <input type="radio" class="tabs__radio" name="tabs-example" id="tab5">
                                <label for="tab5" class="tabs__label">Đã giao</label>
                                <div class="tabs__content">

                                    @if (count($order_delivered) > 0)

                                        @foreach ($all_order as $order)
                                            @foreach ($order_delivered as $status_order_detail)
                                                @if ($status_order_detail->status_id == 4 && $status_order_detail->order_id == $order->order_id)
                                                    <div class="tab__content-item">
                                                        <div class="heading-item">
                                                            @foreach ($status_order as $status)
                                                                @if ($status->status_id == 4)
                                                                    <span class="heading-item-status">{{ $status->status_name }}</span>
                                                                @endif
                                                            @endforeach
                                                        </div>

                                                        <ul class="content-item-list">

                                                            @foreach ($all_order_item as $order_item)
                                                                @if ($order_item->order_id == $order->order_id)

                                                                    <a href="#" class="content-item-link">
                                                                        <li class="content-item">
                                                                            @foreach ($all_product as $product)
                                                                                @if ($product->product_id == $order_item->product_id)
                                                                                    <a href="{{ URL::to('product_detail_slug/' . $product->slug) }}">
                                                                                        <img src="{{ asset('public/upload/' . $product->product_image) }}" alt="" class="content-item-img">
                                                                                    </a>
                                                                                @endif
                                                                            @endforeach
                                                                            <div class="content-item-info">
                                                                                <div class="content-item-head">
                                                                                    @foreach ($all_product as $product)
                                                                                        @if ($order_item->product_id == $product->product_id)
                                                                                            <a href="{{ URL::to('product_detail_slug/' . $product->slug) }}">
                                                                                                <h5 class="content-item-name">
                                                                                                    {{ $product->product_name }}
                                                                                                </h5>
                                                                                            </a>
                                                                                        @endif
                                                                                    @endforeach

                                                                                    <div class="content-item-price-wrap">
                                                                                        <span class="content-item-price">{{ number_format($order_item->quantity_product * $order_item->price_product, 0, '', ',') }}₫</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="content-item-body">
                                                                                    <span class="content-item-quantity">Số
                                                                                        lượng x
                                                                                        {{ $order_item->quantity_product }}</span>
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                    </a>

                                                                @endif
                                                            @endforeach

                                                        </ul>
                                                        <footer class="content-item-footer">
                                                            <span class="content-item-total">Tổng tiền:
                                                                {{ number_format($order->total_price, 0, '.', ',') }}₫</span>
                                                        </footer>
                                                        <footer class="content-btn-footer">
                                                            <a href="{{ URL::to('user/order/' . $order->order_id) }}" class="item-btn-footer-primary">Xem chi tiết đơn hàng</a>
                                                        </footer>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endforeach

                                    @else
                                        <div class="tab__content-item">
                                            <div class="content-item-empty">
                                                <img src="{{ asset('public/upload/empty.png') }}" width="200" height="200" alt="">
                                                <span class="content-item-empty-text">Hiện không có đơn hàng nào đang đã giao</span>
                                            </div>
                                        </div>
                                    @endif

                                </div>

                                <input type="radio" class="tabs__radio" name="tabs-example" id="tab6">
                                <label for="tab6" class="tabs__label">Đã hủy</label>
                                <div class="tabs__content">

                                    @if (count($order_cancelled) > 0)

                                        @foreach ($all_order as $order)
                                            @foreach ($order_cancelled as $status_order_detail)
                                                @if ($status_order_detail->status_id == 5 && $status_order_detail->order_id == $order->order_id)
                                                    <div class="tab__content-item">
                                                        <div class="heading-item">
                                                            @foreach ($status_order as $status)
                                                                @if ($status->status_id == 5)
                                                                    <span class="heading-item-status-cancel">{{ $status->status_name }}</span>
                                                                @endif
                                                            @endforeach
                                                        </div>

                                                        <ul class="content-item-list">

                                                            @foreach ($all_order_item as $order_item)
                                                                @if ($order_item->order_id == $order->order_id)

                                                                    <a href="#" class="content-item-link">
                                                                        <li class="content-item">
                                                                            @foreach ($all_product as $product)
                                                                                @if ($product->product_id == $order_item->product_id)
                                                                                    <a href="{{ URL::to('product_detail_slug/' . $product->slug) }}">
                                                                                        <img src="{{ asset('public/upload/' . $product->product_image) }}" alt="" class="content-item-img">
                                                                                    </a>
                                                                                @endif
                                                                            @endforeach
                                                                            <div class="content-item-info">
                                                                                <div class="content-item-head">
                                                                                    @foreach ($all_product as $product)
                                                                                        @if ($order_item->product_id == $product->product_id)
                                                                                            <a href="{{ URL::to('product_detail_slug/' . $product->slug) }}">
                                                                                                <h5 class="content-item-name">
                                                                                                    {{ $product->product_name }}
                                                                                                </h5>
                                                                                            </a>
                                                                                        @endif
                                                                                    @endforeach

                                                                                    <div class="content-item-price-wrap">
                                                                                        <span class="content-item-price">{{ number_format($order_item->quantity_product * $order_item->price_product, 0, '', ',') }}₫</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="content-item-body">
                                                                                    <span class="content-item-quantity">Số
                                                                                        lượng x
                                                                                        {{ $order_item->quantity_product }}</span>
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                    </a>

                                                                @endif
                                                            @endforeach

                                                        </ul>
                                                        <footer class="content-item-footer">
                                                            <span class="content-item-total">Tổng tiền:
                                                                {{ number_format($order->total_price, 0, '.', ',') }}₫</span>
                                                        </footer>
                                                        <footer class="content-btn-footer">
                                                            <button class="item-btn-footer-primary--disable">Xem chi tiết
                                                                đơn hàng</button>
                                                        </footer>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endforeach

                                    @else
                                        <div class="tab__content-item">
                                            <div class="content-item-empty">
                                                <img src="{{ asset('public/upload/empty.png') }}" width="200" height="200" alt="">
                                                <span class="content-item-empty-text">Hiện không có đơn hàng nào đã hủy</span>
                                            </div>
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="modal_delete_order modal" id="modal_delete_order">
        <!-- Modal content -->
        <div class="modal-content containe mobile_modal_cancel_order" style="height: auto">
            <div class="modal-header-cus">
                <span class="close close_cancel_order">&times;</span>
                <h4>Thông báo</h4>
            </div>
            <div class="modal-body-cus">
                <div class="content">
                    Bạn có thực sự muốn hủy đơn hàng này không?
                    <form>
                        @csrf
                        <input type="hidden" name="order_id" class="cancel_order" id="order_id">
                    </form>
                </div>
            </div>
            <div class="content-modal-footer">
                <button class="btn btn-success btn_cancel_order" style="margin-right: 10px">HỦY</button>
                <button class="btn btn-secondary close_cancel_order" style="margin-right: 10px">TRỞ LẠI</button>
            </div>
        </div>
    </div>
    <script src="{{ asset('public/font_end/assets/js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('public/font_end/custom_account/cancel_order.js') }}"></script>
@endsection
