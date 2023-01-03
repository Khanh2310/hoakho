@extends('admin.layout_admin')
@section('container')
    <link rel="stylesheet" href="{{ asset('public/back_end/custom_customer_admin/custom_css.css') }}">
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ URL::to('admin/') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item"><a href="{{ URL::to('admin/all_customer') }}">Danh sách khách
                                    hàng</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Chi tiết khách hàng</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
                <div class="pd-20 card-box height-100-p">
                    <div class="profile-photo">
                        <img src="{{ asset('public/upload/' . $customer_info->customer_avt) }}" alt="" style="border: 1px solid #e9ecef; width:160px; height:160px;" class="avatar-photo">
                        <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-body pd-5">
                                        <div class="img-container">
                                            <img id="image" src="vendors/images/photo2.jpg" alt="Picture">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($customer_info->customer_fullname != '')
                        <h5 class="text-center h5 mb-0">{{ $customer_info->customer_fullname }}</h5>
                    @else
                        <h5 class="text-center h5 mb-0">{{ $customer->username }}</h5>
                    @endif
                    {{-- <p class="text-center text-muted font-14">Lorem ipsum dolor sit amet</p> --}}
                    <div class="profile-info">
                        <h5 class="mb-20 h5 text-blue">Thông tin chi tiết</h5>
                        <ul>
                            <li>
                                <span>Email:</span>
                                {{ $customer->email }}
                            </li>
                            <li>
                                <span>Số điện thoại:</span>
                                @if ($customer_info->customer_phone != '')
                                    {{ $customer_info->customer_phone }}
                                @else
                                    Chưa cập nhật
                                @endif
                            </li>
                            <li>
                                <span>Giới tính:</span>
                                @if ($customer_info->customer_gender != '')
                                    {{ $customer_info->customer_gender }}
                                @else
                                    Chưa cập nhật
                                @endif
                            </li>
                            <li>
                                <span>Sinh nhật:</span>
                                @if ($customer_info->customer_birthday != '')
                                    {{ date('d-m-Y', strtotime($customer_info->customer_birthday)) }}
                                @else
                                    Chưa cập nhật
                                @endif
                            </li>
                            <li>
                                <span>Địa chỉ mặc định:</span>
                                @if (isset($customer_trans->trans_address))
                                    {{ $customer_trans->trans_address }}
                                @else
                                    Chưa cập nhật
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-30">
                <div class="card-box height-100-p overflow-hidden">
                    <div class="tab-content">
                        <!-- Timeline Tab start -->
                        <div class="tab-pane fade show active" role="tabpanel">
                            <div class="pd-10 content_filter_order_customer">
                                @if (count($all_order) > 0)
                                    <div class="row" style="margin-top: 15px; margin-bottom: -15px; padding-left: 10px;">
                                        <div class="col-sm-12 col-md-6 d-flex">
                                            <div class="content_filter pl-20">
                                                <div class="dropdown">
                                                    <a class="btn btn-success dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                                                        <i class="icon-copy dw dw-filter"></i> Lọc
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-left" style="">
                                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#Modal_filter_order_customer_follow_price">Giá</a>
                                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#Modal_filter_order_customer_follow_date">Ngày mua
                                                            hàng</a>
                                                        <input type="hidden" class="customer_id" value="{{ $customer_id }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="content_print_pdf_product ml-10">
                                                <form action="{{ URL::to('admin/print_pdf_order_customer/' . $customer->customer_id) }}" method="post">
                                                    @csrf
                                                    {{-- type filter --}}
                                                    <input type="hidden" class="type_filter" name="type_filter" value="">
                                                    <input type="hidden" class="level_filter" name="level_filter" value="">
                                                    <input type="hidden" name="level_array" value="">
                                                    <input type="hidden" name="price_filter_start" value="">
                                                    <input type="hidden" name="price_filter_end" value="">
                                                    {{--  --}}
                                                    <button type="submit" class="btn btn-secondary">
                                                        Xuất
                                                        <img src="{{ asset('public/upload/pdf1.svg') }}" style="height: 25px" alt="">
                                                    </button>
                                                </form>
                                            </div>

                                        </div>

                                    </div>
                                @endif
                                <div class="profile-timeline">
                                    <div class="h3 mb-0">Thông tin đơn hàng</div>
                                    <div class="profile-timeline-list">
                                        @if (count($all_order) > 0)
                                            <ul>
                                                @php
                                                    $stt = 0;
                                                @endphp
                                                @foreach ($all_order as $order)
                                                    @php
                                                        $stt++;
                                                        $val_discount_voucher = App\Http\Controllers\CustomerAdminController::check_voucher_order($order->order_id);
                                                    @endphp
                                                    <li style="padding-left: 5px;">
                                                        <div class="cus_head_order_customer collapsed" data-toggle="collapse" data-target="#table-order-{{ $stt }}" aria-expanded="false">
                                                            <div class="cus_head_order_customer--left">
                                                                <div class="cus_date_order_customer">
                                                                    {{ date('d-m-y H:i a', strtotime($order->create_at)) }}
                                                                </div>
                                                                <div class="cus_code_order_customer">Mã đơn hàng:
                                                                    {{ $order->order_code }}</div>
                                                            </div>
                                                            <div class="cus_head_order_customer--right">
                                                                @foreach ($all_order_detail_status as $order_detail_status)
                                                                    @if ($order->order_id == $order_detail_status->order_id && $order_detail_status->status == 1)
                                                                        @foreach ($status_order as $status)
                                                                            @if ($status->status_id == $order_detail_status->status_id)
                                                                                @if ($order_detail_status->status_id == 1)
                                                                                    <span class="cus_status_order_customer badge badge-warning">{{ $status->status_name }}</span>
                                                                                @elseif($order_detail_status->status_id
                                                                                    == 2)
                                                                                    <span class="cus_status_order_customer badge badge-info">{{ $status->status_name }}</span>
                                                                                @elseif($order_detail_status->status_id
                                                                                    == 3)
                                                                                    <span class="cus_status_order_customer badge" style="background-color:rgb(0, 180, 137); color: white;">{{ $status->status_name }}</span>
                                                                                @elseif($order_detail_status->status_id
                                                                                    == 4)
                                                                                    <span class="cus_status_order_customer badge badge-success">{{ $status->status_name }}</span>
                                                                                @elseif($order_detail_status->status_id
                                                                                    == 5)
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
                                                                                        <span class="cus_bottom_order_customer--text">Người
                                                                                            nhận</span>
                                                                                        <span>{{ $tr->trans_fullname }}</span>
                                                                                    </div>
                                                                                    <div class="cus_bottom_order_customer--info">
                                                                                        <span class="cus_bottom_order_customer--text">Số
                                                                                            điện thoại</span>
                                                                                        <span>{{ $tr->trans_phone }}</span>
                                                                                    </div>
                                                                                    <div class="cus_bottom_order_customer--info">
                                                                                        <span class="cus_bottom_order_customer--text">Địa
                                                                                            chỉ giao hàng</span>
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
                                                                                                <img src="{{ asset('public/upload/' . $product->product_image) }}" style="width: 40px; height: 40px; border-radius:5px" width="40" height="40" alt="">
                                                                                            </div>
                                                                                            <div class="txt">
                                                                                                <div class="weight-600">
                                                                                                    {{ $product->product_name }}
                                                                                                </div>
                                                                                            </div>
                                                                                        @endif
                                                                                    @endforeach
                                                                                </div>
                                                                            </td>
                                                                            <td class="text-center">
                                                                                {{ $order_item->quantity_product }}</td>
                                                                            <td class="text-center">
                                                                                {{ number_format($order_item->price_product, 0, ',', '.') }}
                                                                                ₫</td>
                                                                            @php
                                                                                
                                                                            @endphp
                                                                        </tr>
                                                                    @endif
                                                                @endforeach
                                                                @php
                                                                    $fee_ship = $order->fee_ship;
                                                                    $fee_voucher = $val_discount_voucher;
                                                                @endphp
                                                                <tr>
                                                                    <td colspan="2" style="text-align: right; font-size: 16px">
                                                                        Voucher
                                                                    </td>
                                                                    <td>
                                                                        {{ number_format($fee_voucher, 0, ',', '.') }}₫
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2" style="text-align: right; font-size: 16px">
                                                                        Phí vận chuyển
                                                                    </td>
                                                                    <td>
                                                                        {{ number_format($fee_ship, 0, ',', '.') }}₫
                                                                    </td>
                                                                </tr>
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
                                                                    <td style="font-size: 14px">
                                                                        {{ number_format($order->total_price, 0, ',', '.') }}₫
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <div class="center" style="padding-top: 100px;">
                                                <img src="{{ asset('public/upload/empty.png') }}" width="200" height="200" alt=""><br>
                                                khách hàng chưa đặt đơn hàng nào
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Timeline Tab End -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.customer.modal_filter_order_customer')
    <script src="{{ asset('public/font_end/assets/js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('public/back_end/filter_customer/filter_order_customer.js') }}"></script>
@endsection
