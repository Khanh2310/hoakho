<link rel="stylesheet" href="{{ asset('public/font_end/custom_account/user_sidebar_content.css') }}">
@extends('client.layout_account_client')
@section('content_body')
    <link rel="stylesheet" href="{{ asset('public/font_end/custom_account/custom_order_detail.css') }}">
    <link rel="stylesheet" href="{{ asset('public/font_end/custom_account/timeline.css') }}">
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
    <div class="container laptop">
        <nav class="biolife-nav cus_breadcrumb">
            <ul>
                <li class="nav-item"><a href="{{ URL::to('/') }}" class="permal-link">Trang chủ</a></li>
                <li class="nav-item"><a href="{{ URL::to('user/account') }}" class="permal-link">Tài khoản</a></li>
                <li class="nav-item"><a href="{{ URL::to('user/order') }}" class="permal-link">Đơn Hàng</a></li>
                <li class="nav-item"><span class="current-page">Chi Tiến Đơn hàng</span></li>
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
                        <nav class="user laptop">
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
                        </nav>
                    </div>

                    <!--content-user-->
                    <div class="laptop">
                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12" style="display: flex; margin-bottom: 32px;">
                            <div class="content__user-order-detail">
                                <div class="head-order-detail">
                                    <div class="head-order-detail-back">
                                        <a class="head-order-detail-back--link" href="{{ URL::to('user/order') }}">
                                            <span class="mobile_back_all_order">
                                                <i class="icon-copy ti-angle-left"></i> TRỞ LẠI
                                            </span>
                                        </a>
                                    </div>
                                    <div class="head-order-detail-right">
                                        <span class="head-order-detail-right--text-id">ID ĐƠN HÀNG:
                                            {{ $order->order_code }}</span>
                                        <span class="head-order-detail-right--separation"></span>
                                        @foreach ($all_order_detail_status as $status_order_detail)
                                            @if ($status_order_detail->order_id == $order->order_id)
                                                @foreach ($status_order as $status)
                                                    @if ($status->status_id == $status_order_detail->status_id && $status_order_detail->status == 1)
                                                        <span class="head-order-detail-right--text-status">{{ $status->status_name }}</span>
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                {{-- <div class="separation"></div> --}}
                                <div class="step-process-bar-order-detail">
                                    <ul class="progressbar">
                                        <li class="active">
                                            <span>Đơn Hàng Đã Đặt</span><br>
                                            <span class="progressbar-time">{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $order->create_at)->format('H:i d-m-Y') }}</span>
                                        </li>
                                        <li @foreach ($all_order_detail_status as $order_detail_status)
                                            @if ($order_detail_status->order_id == $order->order_id && $order_detail_status->status_id == 2)
                                                class="active"
                                            @endif
                                            @endforeach
                                            >
                                            <span>Đã Xác Nhận Đơn Hàng</span><br>
                                            <span class="progressbar-time">
                                                @foreach ($all_order_detail_status as $order_detail_status)
                                                    @if ($order_detail_status->order_id == $order->order_id && $order_detail_status->status_id == 2)
                                                        {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $order_detail_status->time_status)->format('H:i d-m-Y') }}
                                                    @endif
                                                @endforeach
                                            </span>
                                        </li>
                                        <li @foreach ($all_order_detail_status as $order_detail_status)
                                            @if ($order_detail_status->order_id == $order->order_id && $order_detail_status->status_id == 3)
                                                class="active"
                                            @endif
                                            @endforeach
                                            >
                                            <span>Đơn Hàng Đang Giao</span><br>
                                            <span class="progressbar-time">
                                                @foreach ($all_order_detail_status as $order_detail_status)
                                                    @if ($order_detail_status->order_id == $order->order_id && $order_detail_status->status_id == 3)
                                                        {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $order_detail_status->time_status)->format('H:i d-m-Y') }}
                                                    @endif
                                                @endforeach
                                            </span>
                                        </li>
                                        <li @foreach ($all_order_detail_status as $order_detail_status)
                                            @if ($order_detail_status->order_id == $order->order_id && $order_detail_status->status_id == 4)
                                                class="active"
                                            @endif
                                            @endforeach
                                            >
                                            <span>Đơn Hàng Đã Giao</span><br>
                                            <span class="progressbar-time">
                                                @foreach ($all_order_detail_status as $order_detail_status)
                                                    @if ($order_detail_status->order_id == $order->order_id && $order_detail_status->status_id == 4)
                                                        {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $order_detail_status->time_status)->format('H:i d-m-Y') }}
                                                    @endif
                                                @endforeach
                                            </span>
                                        </li>
                                    </ul>
                                </div>

                                <div class="_1G9Cv7"></div>
                                <div class="order-detail-address">
                                    <div class="title-order-detail-address">
                                        <span>Địa Chỉ Nhận Hàng</span>
                                    </div>
                                    <div class="content-order-detail-address">
                                        <div class="content-order-detail-address--left">
                                            @foreach ($trans_address as $address)
                                                @if ($order->trans_id == $address->trans_id)
                                                    <span class="content-order-detail-address--left-name">{{ $address->trans_fullname }}</span>
                                                    <span class="content-order-detail-address--left-phone">{{ $address->trans_phone }}</span>
                                                    <span class="content-order-detail-address--left-address">{{ $address->trans_address }}</span>
                                                @endif
                                            @endforeach
                                        </div>
                                        <div class="content-order-detail-address--right">
                                            <ul class="timeline">
                                                @foreach ($all_order_detail_status as $order_detail_status)
                                                    @if ($order_detail_status->order_id == $order->order_id)
                                                        <li @if ($order_detail_status->status == 1)
                                                            class="timeline-active"
                                                    @endif
                                                    >
                                                    <span class="timeline--datetime">{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $order_detail_status->time_status)->format('H:i d-m-Y') }}</span>
                                                    <span class="timeline--status" @if ($order_detail_status->status == 1)
                                                        id="timeline--status-active"
                                                @endif
                                                >
                                                @foreach ($status_order as $status)
                                                    @if ($status->status_id == $order_detail_status->status_id)
                                                        {{ $status->message_status }}
                                                    @endif
                                                @endforeach
                                                </span>
                                                </li>
                                                @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="separation"></div>
                                <div class="order-detail-product">
                                    <div class="title-order-detail-product">
                                        <span>Sản Phẩm Đã Mua</span>
                                    </div>
                                    <div class="content-order-detail-product">
                                        <ul class="content-item-list">
                                            @foreach ($all_order_item as $order_item)
                                                @if ($order_item->order_id == $order->order_id)
                                                    @foreach ($all_product as $product)
                                                        @if ($product->product_id == $order_item->product_id)
                                                            <a href="#" class="content-item-link">
                                                                <li class="content-item" style="border-top: 1px solid #d4d3d3; margin-bottom: 2px;">
                                                                    <a href="{{ URL::to('product_detail_slug/' . $product->slug) }}"><img src="{{ asset('public/upload/' . $product->product_image) }}" alt="" class="content-item-img"></a>
                                                                    <div class="content-item-info">
                                                                        <div class="content-item-head">
                                                                            <h5 class="content-item-name">
                                                                                <a href="{{ URL::to('product_detail_slug/' . $product->slug) }}">{{ $product->product_name }}</a>
                                                                            </h5>
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
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="order-detail-bill">
                                    @php
                                        $fee_ship = $order->fee_ship;
                                        $val_discount_voucher = App\Http\Controllers\CustomerAdminController::check_voucher_order($order->order_id);
                                        $fee_voucher = $val_discount_voucher;
                                    @endphp
                                    <div class="item-order-detail-bill">
                                        <div class="item-order-detail-bill--left">
                                            <span>Voucher</span>
                                        </div>
                                        <div class="item-order-detail-bill--right">
                                            -{{ number_format($fee_voucher, 0, '.', '.') }}₫
                                        </div>
                                    </div>
                                    <div class="item-order-detail-bill">
                                        <div class="item-order-detail-bill--left">
                                            <span>Phí vận chuyển</span>
                                        </div>
                                        <div class="item-order-detail-bill--right">
                                            {{ number_format($fee_ship, 0, '.', '.') }}₫
                                        </div>
                                    </div>
                                    <div class="item-order-detail-bill">
                                        <div class="item-order-detail-bill--left">
                                            <span>Tổng số tiền</span>
                                        </div>
                                        <div class="item-order-detail-bill--right item-order-detail-bill--right-total-price">
                                            {{ number_format($order->total_price, 0, '.', '.') }}₫
                                        </div>
                                    </div>
                                </div>
                                <div class="order-detail-payment-methods">
                                    <div class="separation"></div>
                                    <div class="item-order-detail-bill">
                                        <div class="item-order-detail-bill--left">
                                            <img src="{{ asset('public/upload/payment_method.svg') }}" alt="" width="30" height="10">
                                            <span>Phương thức thanh toán</span>
                                        </div>
                                        <div class="item-order-detail-bill--right">
                                            @foreach ($payment_method as $pay)
                                                @if ($pay->payment_id == $order->payment_id)
                                                    {{ $pay->payment_name }}
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- responsive mobile --}}
                    <div class="mobile">
                        @include('client.layout.responsive_mobile.order_detail_mobile')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
