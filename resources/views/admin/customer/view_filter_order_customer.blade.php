<input type="hidden" name="_token" value="{{ csrf_token() }}" />
<div class="row" style="margin-top: 15px; margin-bottom: -15px; padding-left: 10px;">
    <div class="col-sm-12 col-md-6 d-flex">
        <div class="content_filter pl-20">
            <div class="dropdown">
                <a class="btn btn-success dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                    <i class="icon-copy dw dw-filter"></i> Lọc
                </a>
                <div class="dropdown-menu dropdown-menu-left" style="">
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#Modal_filter_order_customer_follow_price">Giá</a>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#Modal_filter_order_customer_follow_date">Ngày mua hàng</a>
                    <input type="hidden" class="customer_id" value="{{ $customer_id }}">
                </div>
            </div>
        </div>
        @if (count($all_order) > 0)
            <div class="content_print_pdf_product ml-10">
                <form action="{{ URL::to('admin/print_pdf_order_customer/' . $customer_id) }}" method="post">
                    @csrf
                    @if (isset($type_filter))
                        <input type="hidden" class="type_filter" name="type_filter" value="{{ $type_filter }}">
                        <input type="hidden" class="level_filter" name="level_filter" value="{{ $level_filter }}">
                        @if (isset($price_filter_start) && isset($price_filter_end))
                            <input type="hidden" name="price_filter_start" value="{{ $price_filter_start }}">
                            <input type="hidden" name="price_filter_end" value="{{ $price_filter_end }}">
                        @else
                            <input type="hidden" name="price_filter_start" value="">
                            <input type="hidden" name="price_filter_end" value="">
                        @endif
                        @if (isset($start_date) && isset($end_date))
                            <input type="hidden" name="start_date" value="{{ $start_date }}">
                            <input type="hidden" name="end_date" value="{{ $end_date }}">
                        @else
                            <input type="hidden" name="start_date" value="">
                            <input type="hidden" name="end_date" value="">
                        @endif
                    @else
                        <input type="hidden" class="type_filter" name="type_filter" value="">
                        <input type="hidden" class="level_filter" name="level_filter" value="">
                    @endif
                    <button type="submit" class="btn btn-secondary">
                        Xuất
                        <img src="{{ asset('public/upload/pdf1.svg') }}" style="height: 25px" alt="">
                    </button>
                </form>
            </div>
        @endif
    </div>
</div>
<div class="profile-timeline">
    <div class="h3 mb-0">Thông tin đơn hàng</div>
    <div class="h5 mb-0">{{ $string_title }}</div>
    @if (count($all_order) > 0)
        <div class="text-center pd-10">
            "Tìm thấy <span style="color: blue">{{ count($all_order) }}</span> kết quả phù hợp"
        </div>
        <div class="profile-timeline-list">
            <ul>
                @php
                    $stt = 0;
                @endphp
                @foreach ($all_order as $order)
                    @php
                        $stt++;
                    @endphp
                    <li style="padding-left: 5px;">
                        <div class="cus_head_order_customer collapsed" data-toggle="collapse" data-target="#table-order-{{ $stt }}" aria-expanded="false">
                            <div class="cus_head_order_customer--left">
                                <div class="cus_date_order_customer">{{ date('d-m-y H:i a', strtotime($order->create_at)) }}</div>
                                <div class="cus_code_order_customer">Mã đơn hàng: {{ $order->order_code }}</div>
                            </div>
                            <div class="cus_head_order_customer--right">
                                @foreach ($all_order_detail_status as $order_detail_status)
                                    @if ($order->order_id == $order_detail_status->order_id && $order_detail_status->status == 1)
                                        @foreach ($status_order as $status)
                                            @if ($status->status_id == $order_detail_status->status_id)
                                                @if ($order_detail_status->status_id == 1)
                                                    <span class="cus_status_order_customer badge badge-warning">{{ $status->status_name }}</span>
                                                @elseif($order_detail_status->status_id == 2)
                                                    <span class="cus_status_order_customer badge badge-info">{{ $status->status_name }}</span>
                                                @elseif($order_detail_status->status_id == 3)
                                                    <span class="cus_status_order_customer badge" style="background-color:rgb(0, 180, 137); color: white;">{{ $status->status_name }}</span>
                                                @elseif($order_detail_status->status_id == 4)
                                                    <span class="cus_status_order_customer badge badge-success">{{ $status->status_name }}</span>
                                                @elseif($order_detail_status->status_id == 5)
                                                    <span class="cus_status_order_customer badge badge-danger">{{ $status->status_name }}</span>
                                                @endif
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <table class="table table-bordered collapse" id="table-order-{{ $stt }}">
                            <div class="_1G9Cv7"></div>
                            <thead>
                                <tr>
                                    <td colspan="3">
                                        <div class="cus_bottom_order_customer">
                                            @foreach ($trans as $tr)
                                                @if ($order->trans_id == $tr->trans_id)
                                                    <div class="cus_bottom_order_customer--info">
                                                        <span class="cus_bottom_order_customer--text">Người nhận</span>
                                                        <span>{{ $tr->trans_fullname }}</span>
                                                    </div>
                                                    <div class="cus_bottom_order_customer--info">
                                                        <span class="cus_bottom_order_customer--text">Số điện thoại</span>
                                                        <span>{{ $tr->trans_phone }}</span>
                                                    </div>
                                                    <div class="cus_bottom_order_customer--info">
                                                        <span class="cus_bottom_order_customer--text">Địa chỉ giao hàng</span>
                                                        <span>{{ $tr->trans_address }}</span>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Sản Phẩm</th>
                                    <th class="text-center">Số Lượng</th>
                                    <th class="text-center">Giá</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($all_order_item as $order_item)
                                    @if ($order_item->order_id == $order->order_id)
                                        <tr>
                                            <td class="table-plus sorting_1" tabindex="0">
                                                <div class="name-avatar d-flex align-items-center">
                                                    @foreach ($all_product as $product)
                                                        @if ($order_item->product_id == $product->product_id)
                                                            <div class="avatar mr-2 flex-shrink-0">
                                                                <img src="{{ asset('public/upload/' . $product->product_image) }}" style="width: 40px; height: 40px; border-radius:5px" width="40"
                                                                    height="40" alt="">
                                                            </div>
                                                            <div class="txt">
                                                                <div class="weight-600">{{ $product->product_name }}</div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td class="text-center">{{ $order_item->quantity_product }}</td>
                                            <td class="text-center">{{ number_format($order_item->price_product, 0, ',', '.') }} ₫</th>
                                        </tr>
                                        @if ($order->voucher_code != '')
                                            <tr>
                                                <td colspan="2" style="text-align: right;">
                                                    Đơn hàng áp dụng mã Voucher <span style="color: blue; font-weight: 500; font-size: 16px;">{{ $order->voucher_code }}</span>
                                                </td>
                                                <td>
                                                    @foreach ($all_voucher as $voucher)
                                                        @if ($voucher->voucher_code == $order->voucher_code)
                                                            -{{ number_format($voucher->voucher_amount, 0, ',', '.') }} ₫
                                                        @endif
                                                    @endforeach
                                                </td>
                                            </tr>
                                        @endif
                                    @endif
                                @endforeach
                                <tr>
                                    <td colspan="2" style="text-align: right; font-size: 16px">
                                        <div class="cus_pay_order_customer">
                                            @foreach ($payment_method as $pay)
                                                @if ($pay->payment_id == $order->payment_id)
                                                    <span><img src="{{ asset('public/upload/dollar.png') }}" alt="" style="height: 25px; width:25px;">{{ $pay->payment_name }}</span>
                                                @endif
                                            @endforeach
                                            <span>Tổng giá đơn hàng:</span>
                                        </div>
                                    </td>
                                    <td style="font-size: 14px">{{ number_format($order->total_price, 0, ',', '.') }} ₫</td>
                                </tr>
                            </tbody>
                        </table>
                    </li>
                @endforeach
            </ul>
            <div class="center">
                <a href="" class="btn btn-outline-dark">
                    <i class="icon-copy fa fa-history" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    @else
        <div class="center">
            Không tìm thấy kết quả nào
            <a href="" class="btn btn-outline-dark">
                <i class="icon-copy fa fa-history" aria-hidden="true"></i>
            </a>
        </div>
    @endif
</div>
<script src="{{ asset('public/back_end/filter_customer/filter_order_customer.js') }}"></script>
{{-- sort table --}}
<script src="{{ asset('public/back_end/sort_table/Scripts/bootstrap-sortable.js') }}"></script>
