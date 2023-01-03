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
        <div class="_1G9Cv7"></div>
        <div class="order-detail-address">
            <div class="title-order-detail-address">
                <span>Địa Chỉ Nhận Hàng</span>
            </div>
            <div class="row">
                <div
                    class="content-order-detail-address--left"
                    style="padding: 2px 20px">
                    @foreach ($trans_address as $address)
                        @if ($order->trans_id == $address->trans_id)
                            <span class="content-order-detail-address--left-name">{{ $address->trans_fullname }}</span>
                            <span class="content-order-detail-address--left-phone">{{ $address->trans_phone }}</span>
                            <span class="content-order-detail-address--left-address">{{ $address->trans_address }}</span>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="row">
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
                                            <a href="{{ URL::to('product_detail_slug/' . $product->slug) }}">
                                                <img src="{{ asset('public/upload/' . $product->product_image) }}" style="margin: 5px" alt="" class="content-item-img">
                                            </a>
                                            <div class="content-item-info">
                                                <div class="content-item-head">
                                                    <h5 class="content-item-name">
                                                        <a href="{{ URL::to('product_detail_slug/' . $product->slug) }}">{{ $product->product_name }}</a>
                                                    </h5>
                                                    <div class="content-item-price-wrap">
                                                        <span class="content-item-price px-12">
                                                            {{ number_format($order_item->quantity_product * $order_item->price_product, 0, '', '.') }}₫
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="content-item-body">
                                                    <span class="content-item-quantity px-12">Số lượng x
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
                    <span class="px-12">Voucher</span>
                </div>
                <div class="item-order-detail-bill--right px-12">
                    -{{ number_format($fee_voucher, 0, '.', '.') }}₫
                </div>
            </div>
            <div class="item-order-detail-bill">
                <div class="item-order-detail-bill--left">
                    <span class="px-12">Phí vận chuyển</span>
                </div>
                <div class="item-order-detail-bill--right px-12">
                    {{ number_format($fee_ship, 0, '.', '.') }}₫
                </div>
            </div>
            <div class="item-order-detail-bill">
                <div class="item-order-detail-bill--left">
                    <span class="px-12">Tổng số tiền</span>
                </div>
                <div class="item-order-detail-bill--right item-order-detail-bill--right-total-price" style="font-size: 14px">
                    {{ number_format($order->total_price, 0, '.', '.') }}₫
                </div>
            </div>
        </div>
        <div class="order-detail-payment-methods">
            <div class="separation"></div>
            <div class="item-order-detail-bill">
                <div class="item-order-detail-bill--left">
                    <img src="{{ asset('public/upload/payment_method.svg') }}" alt="" width="30" height="10">
                    <span class="px-12">Phương thức thanh toán</span>
                </div>
                <div class="item-order-detail-bill--right px-12">
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
