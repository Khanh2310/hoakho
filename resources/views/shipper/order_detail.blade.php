<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/back_end/vendors/styles/core.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/back_end/vendors/styles/icon-font.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/back_end/vendors/styles/style.css') }}">
    <link rel="stylesheet" href="{{ asset('public/font_end/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/back_end/custom_shipper/custom_css.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/back_end/vendors/styles/style.css') }}">


    {{-- <link rel="stylesheet" type="text/css"
        href="{{ asset('public/back_end/src/plugins/datatables/css/responsive.bootstrap4.min.css') }}"> --}}
    <title>Duyệt đơn hàng</title>
    <style>
        body {
            font-size: 18px;
        }

    </style>
</head>

<body>
    <div class="login-header box-shadow">
        <div class="container-fluid d-flex">
            <div class="brand-logo">
                <a href="#">
                    <img src="{{ asset('public/upload/logo-flower.svg') }}" alt="" style="height: 46px;">
                </a>
            </div>
            <div class="login-menu d-flex align-items-center justify-content-end" style="width: 100%">
                @if (Session::get('admin_id'))
                    <span class="user-icon">
                        <img src="{{ asset('public/upload/' . Session::get('admin_image')) }}" alt="" style="width: 52px; height: 52px; border-radius: 50%;">
                    </span>
                    <span class="text-admin-name">{{ Session::get('admin_name') }}</span>
                @endif
                <span class="border"></span>
                <a href="{{ URL::to('logout_shipper') }}" style="color: #1b3133">Đăng xuất</a>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-2">
            </div>
            <div class="col-8">
                <div class="pt-10 pb-10">
                    <h2 class="font-weight-bold">Chi Tiết Đơn Hàng</h2>
                </div>
                <div class="pb-10 d-flex justify-content-between">
                    <a href="{{ URL::to('delivering') }}">
                        <button class="btn btn-secondary">Trở về</button>
                    </a>
                    <div>
                        <button type="button" class="btn btn-danger ml-5 btn_confirm_order_fail" data-toggle="modal" data-target="#modal_confirm_fail" data-id="{{ $order->order_code }}"></i>Hủy Đơn
                            Hàng</button>
                        <button type="button" class="btn btn-success ml-5 btn_confirm_order" data-toggle="modal" data-target="#modal_confirm_delivered" data-id="{{ $order->order_code }}" style="margin-left: 0 !important;"></i>Duyệt Đơn
                            Hàng</button>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <span><strong>Mã Đơn Hàng: </strong><span class="text-primary">{{ $order->order_code }}</span></span>
                    <span><strong>Ngày Mua Hàng:</strong>
                        {{ date('d/m/Y H:i a', strtotime($order->create_at)) }}</span>
                </div>
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <td colspan="3" style="background-color: #fff;">
                                <div class="cus_bottom_order_customer">

                                    <div class="cus_bottom_order_customer--info">
                                        <span class="cus_bottom_order_customer--text">Người nhận</span>
                                        <span>{{ $trans->trans_fullname }}</span>
                                    </div>
                                    <div class="cus_bottom_order_customer--info">
                                        <span class="cus_bottom_order_customer--text">Số điện thoại</span>
                                        <span>{{ $trans->trans_phone }}</span>
                                    </div>
                                    <div class="cus_bottom_order_customer--info">
                                        <span class="cus_bottom_order_customer--text">Địa chỉ giao hàng</span>
                                        <span>{{ $trans->trans_address }}</span>
                                    </div>

                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Sản Phẩm</th>
                            <th class="text-center">Số Lượng</th>
                            <th class="text-center">Giá</th>
                        </tr>
                    </thead>
                    <tbody style="background-color: #fff">
                        @foreach ($order_items as $order_item)
                            @if ($order_item->order_id == $order->order_id)
                                @php
                                    $val_discount_voucher = App\Http\Controllers\CustomerAdminController::check_voucher_order($order->order_id);
                                @endphp
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
                                        ₫</th>
                                </tr>
                                @php
                                    $fee_ship = $order->fee_ship;
                                    $fee_voucher = $val_discount_voucher;
                                @endphp
                                <tr>
                                    <td colspan="2" style="text-align: right; font-size: 16px">
                                        Voucher
                                    </td>
                                    <td class="text-center">
                                        {{ number_format($fee_voucher, 0, ',', '.') }}₫
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: right; font-size: 16px">
                                        Phí vận chuyển
                                    </td>
                                    <td class="text-center">
                                        {{ number_format($fee_ship, 0, ',', '.') }}₫
                                    </td>
                                </tr>
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
                            <td class="text-center" style="font-size: 14px">
                                {{ number_format($order->total_price, 0, ',', '.') }}
                                ₫</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-2">
            </div>
        </div>
    </div>
    @include('shipper.modal_confirm_order')
    <script>
        $(document).ready(function() {
            $("#myInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#myTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
    <script src="{{ asset('public/font_end/assets/js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('public/font_end/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/back_end/custom_shipper/confirm_order.js') }}"></script>
</body>

</html>
