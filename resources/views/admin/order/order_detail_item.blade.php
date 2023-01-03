@extends('admin.layout_admin')
@section('container')
    <div class="min-height-200px">
        {{-- MESSAGE --}}
        @if (session('confirm_success'))
            <div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session('confirm_success') }}
            </div>
        @endif
        @if (session('confirm_delivary_success'))
            <div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session('confirm_delivary_success') }}
            </div>
        @endif
        @if (session('confirm_delivary_success_order'))
            <div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session('confirm_delivary_success_order') }}
            </div>
        @endif
        {{--  --}}
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4>Chi Tiết Đơn Hàng - "{{ $order->order_code }}"</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ URL::to('admin/') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item"><a href="{{ URL::to('admin/all_order') }}">Danh sách đơn hàng</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Chi tiết đơn hàng</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                    {{-- content print pdf --}}
                    <div class="content_print_pdf_delivery">
                        <a href="{{ URL::to('admin/print_pdf_delivery_order/' . $order->order_id) }}" class="btn btn-secondary">
                            In phiếu giao hàng
                            <img src="{{ asset('public/upload/pdf1.svg') }}" style="height: 25px;" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-box pd-20 mb-20">
            <div class="h5">Thông Tin Địa Chỉ Nhận Hàng</div>
            <div class="content_address_delivery pd-10">
                <div class="d-flex">
                    <span class="icon-copy ti-location-pin" style="font-size: 20px;"></span>
                    <div style="margin-left: 10px; font-size: 16px; font-weight: 500">{{ $trans->trans_fullname }} {{ $trans->trans_phone }}</div>
                    <div style="width: 0.5px; margin-left: 5px; margin-right: 5px ;background-color:rgb(205, 214, 212);"></div>
                    <div class="">{{ $trans->trans_address }}</div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
                <div class="pd-20 card-box height-100-p">
                    <div class="pb-10">
                        <div class="h5 mb-10">Trạng Thái Đơn Hàng</div>
                        <div class="profile-timeline-list pd-10">
                            <ul>
                                @foreach ($time_line as $time)
                                    <li>
                                        <div class="date">{{ date('d/m/Y', strtotime($time->time_status)) }}</div>
                                        <div class="task-name"></div>
                                        @foreach ($status_order as $status)
                                            @if ($status->status_id == $time->status_id)
                                                <p>{{ $status->message_status }}</p>
                                            @endif
                                        @endforeach
                                        <div class="task-time">{{ date('H:i a', strtotime($time->time_status)) }}</div>
                                        @if ($time->status_id == 1 && $time->status == 1)
                                            <button type="button" class="btn btn-success btn-sm btn_confirm_order_mini" style="font-size: 12px" data-toggle="modal" data-target="#modal_confirm_order_mini" data-id="{{ $order->order_code }}"><span
                                                    class="icon-copy ti-check-box"></span> Xác Nhận</button>
                                        @elseif($time->status_id == 2 && $time->status == 1)
                                            <button type="button" class="btn btn-success btn-sm btn_confirm_delivery_order_mini" style="font-size: 12px" data-toggle="modal" data-target="#modal_confirm_delivery_order_mini"
                                                data-id="{{ $order->order_code }}"><i class="icon-copy dw dw-truck"></i>... Giao Hàng</button>
                                        @elseif($time->status_id == 3 && $time->status == 1)
                                            @hasrole(['delivery', 'admin'])
                                                <button type="button" class="btn btn-success btn-sm btn_confirm_delivery_order_success_mini" style="font-size: 12px" data-toggle="modal" data-target="#modal_confirm_delivery_order_success_mini"
                                                    data-id="{{ $order->order_code }}"><i class="icon-copy dw dw-delivery-truck-1"></i>Giao Thành Công</button>
                                            @endhasrole
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-30">
                <div class="card-box height-100-p pd-20">
                    <div class="h5 mb-0">Thông tin đơn hàng</div>
                    <div class="pd-10">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Sản Phẩm</th>
                                    <th class="text-center">Số Lượng</th>
                                    <th class="text-center">Giá</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order_item as $item)
                                    <tr>
                                        <td class="table-plus sorting_1" tabindex="0">
                                            <div class="name-avatar d-flex align-items-center">
                                                @foreach ($product as $prod)
                                                    @if ($item->product_id == $prod->product_id)
                                                        <div class="avatar mr-2 flex-shrink-0">
                                                            <img src="{{ asset('public/upload/' . $prod->product_image) }}" style="width: 40px; height: 40px; border-radius:5px" width="40" height="40" alt="">
                                                        </div>
                                                        <div class="txt">
                                                            <div class="weight-600">{{ $prod->product_name }}</div>
                                                        </div>
                                                    @endif

                                                @endforeach

                                            </div>
                                        </td>
                                        <td class="text-center">{{ $item->quantity_product }}</td>
                                        <td class="text-center">{{ number_format($item->price_product, 0, ',', '.') }}₫</th>
                                    </tr>
                                @endforeach
                                @php
                                    $fee_ship = $order->fee_ship;
                                    $val_discount_voucher = App\Http\Controllers\CustomerAdminController::check_voucher_order($order->order_id);
                                    $fee_voucher = $val_discount_voucher;
                                @endphp
                                @if ($order->voucher_code != null)
                                    <tr>
                                        <td colspan="2" style="text-align: right; font-size: 16px">Áp dụng voucher: <b>#{{ $order->voucher_code }}</b> </td>
                                        <td style="font-size: 14px">
                                            {{ number_format($fee_voucher, 0, ',', '.') }}₫
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <td colspan="2" style="text-align: right; font-size: 16px">
                                        Phí vận chuyển
                                    </td>
                                    <td style="font-size: 14px">
                                        {{ number_format($order->fee_ship, 0, ',', '.') }}₫
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: right; font-size: 16px">Tổng giá đơn hàng:</td>
                                    <td style="font-size: 14px">{{ number_format($order->total_price, 0, ',', '.') }}₫</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="pd-10">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">Hình Thức Thanh Toán</th>
                                    <th class="text-center">Tình Trạng Đơn Hàng</th>
                                    <th class="text-center">Trạng Thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">
                                        @foreach ($payment_method as $pay)
                                            @if ($pay->payment_id == $order->payment_id)
                                                {{ $pay->payment_name }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td class="text-center">
                                        @if ($order->status_pay == 1)
                                            <span class="badge badge-success" style="width: 107px">Đã Thanh Toán</span>
                                        @else
                                            <span class="badge badge-danger" style="width: 107px">Chưa Thanh Toán</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @foreach ($status_order as $status)
                                            @if ($detail_status->status_id == $status->status_id)
                                                @if ($detail_status->status_id == 1)
                                                    <span class="badge badge-warning" style="width: 88.5px;">{{ $status->status_name }}</span>
                                                @elseif($detail_status->status_id == 2)
                                                    <span class="badge badge-info" style="width: 88.5px;">{{ $status->status_name }}</span>

                                                @elseif($detail_status->status_id == 3)
                                                    <span class="badge" style="background-color:rgb(0, 180, 137); color: white; width: 88.5px;">{{ $status->status_name }}</span>

                                                @elseif($detail_status->status_id == 4)
                                                    <span class="badge badge-success" style="width: 88.5px;">{{ $status->status_name }}</span>

                                                @elseif($detail_status->status_id == 5)
                                                    <span class="badge badge-danger" style="width: 88.5px;">{{ $status->status_name }}</span>
                                                @endif
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                            </tbody>

                        </table>
                    </div>
                    @hasrole(['admin'])
                        @if (count($admin_action_order) > 0)
                            <div class="pd-10">
                                <table class="table table-bordered">
                                    @foreach ($admin_action_order as $action)
                                        <tr>
                                            <td>
                                                {{ date('d/m/Y H:i a', strtotime($action->action_time)) }}
                                            </td>
                                            <td>
                                                {{ $action->action_message }}
                                            </td>
                                            <td>
                                                {{ $action->admin_name }}
                                            </td>
                                        </tr>
                                    @endforeach

                                </table>
                            </div>
                        @endif
                    @endhasrole
                </div>

            </div>
        </div>
    </div>
    <!-- The Modal confirm order-->
    <div class="modal fade" id="modal_confirm_order_mini">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Thông Báo</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="modal_body_confirm_order_mini">Xác nhận giao thành công đơn hàng</div>
                    <form action="{{ URL::to('admin/confirm_order') }}" method="post" name="form_submit_confirm_order_mini">
                        @csrf
                        <input type="hidden" value="" name="order_code" class="val_order_code_confirm_order_mini">
                    </form>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn_comfirm_modal_confirm_order_mini">Xác Nhận</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                </div>
            </div>
        </div>
    </div>
    <!-- The Modal confirm delivery order-->
    <div class="modal fade" id="modal_confirm_delivery_order_mini">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Thông Báo</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="modal_body_confirm_delivery_order_mini">Xác nhận giao thành công đơn hàng</div>
                    <form action="{{ URL::to('admin/confirm_delivary_order') }}" method="post" name="form_submit_confirm_delivery_order_mini">
                        @csrf
                        <input type="hidden" value="" name="order_code" class="val_order_code_confirm_delivery_order_mini">
                    </form>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn_comfirm_modal_confirm_delivery_order_mini">Xác Nhận</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                </div>
            </div>
        </div>
    </div>
    <!-- The Modal confirm delivery order success-->
    <div class="modal fade" id="modal_confirm_delivery_order_success_mini">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Thông Báo</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="modal_body_confirm_delivery_order_success_mini">Xác nhận giao thành công đơn hàng</div>
                    <form action="{{ URL::to('admin/confirm_delivery_success_order') }}" method="post" name="form_submit_confirm_delivery_order_success_mini">
                        @csrf
                        <input type="hidden" value="" name="order_code" class="val_order_code_confirm_delivery_order_success_mini">
                    </form>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn_comfirm_modal_confirm_delivery_order_success_mini">Xác Nhận</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                </div>
            </div>
        </div>
    </div>
@endsection
