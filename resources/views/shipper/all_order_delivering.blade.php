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

    {{-- <link rel="stylesheet" type="text/css"
        href="{{ asset('public/back_end/src/plugins/datatables/css/responsive.bootstrap4.min.css') }}"> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('public/back_end/vendors/styles/style.css') }}">
    <title>Duyệt đơn hàng</title>
    <style>
        table tbody {
            display: block;
            max-height: 400px;
            overflow-y: scroll;
        }

        table thead,
        table tbody tr {
            display: table;
            table-layout: fixed;
        }

    </style>
</head>

<body>
    <div class="login-header box-shadow">
        <div class="container-fluid d-flex align-items-center">
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
                <div class="card-box mb-30 mt-4">
                    @if (session('confirm_delivery_order_success'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <a href="#" class="close" data-dismiss="alert" aria-label="Close" style="line-height: 10px;">&times;</a>
                            {{ session('confirm_delivery_order_success') }}
                        </div>
                    @endif
                </div>
                <div class="pb-10">
                    <h2 class="font-weight-bold">Danh Sách Đơn Hàng</h2>
                </div>

                <input class="form-control" id="myInput" type="text" placeholder="Nhập mã đơn hàng, số điện thoại người nhận,..">
                <br>
                @if (count($all_order_delivered) > 0)
                    <table class="table table-fixed table-bordered tableFixHead">
                        <thead class="thead-dark">
                            <tr>
                                <th style="width: 150px" class="text-center">Mã Đơn Hàng</th>
                                <th style="width: 400px">Địa Chỉ</th>
                                <th style="width: 163px;" class="text-center">
                                    Duyệt
                                </th>
                            </tr>
                        </thead>
                        <tbody id="myTable" style="background-color: #fff">
                            @foreach ($all_order_delivered as $order)
                                <tr>
                                    <td style="min-width: 150px" class="text-center">
                                        <a href="{{ URL::to('order_detail/' . $order->order_id) }}">
                                            <strong>{{ $order->order_code }}</strong>
                                        </a>
                                    </td>
                                    <td style="min-width: 400px">
                                        @foreach ($transport as $trans)
                                            @if ($order->trans_id == $trans->trans_id)
                                                {{ $trans->trans_fullname }}<br>
                                                {{ $trans->trans_phone }}<br>
                                                {{ $trans->trans_address }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td style="min-width: 163px;" class="text-center">
                                        <button type="button" class="btn btn-danger btn_confirm_order_fail" data-toggle="modal" data-target="#modal_confirm_fail" data-id="{{ $order->order_code }}" style="width: 86px;
    margin-bottom: 4px;"></i>Hủy</button>
                                        <button type="button" class="btn btn-success btn_confirm_order" data-toggle="modal" data-target="#modal_confirm_delivered" data-id="{{ $order->order_code }}" style="width: 86px;"></i>Xác Nhận</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center">Hiện không có đơn nào đang giao!</div>
                @endif
            </div>
            <div class="col-2">
            </div>
        </div>
    </div>
    @include('shipper.modal_confirm_order')
    <script src="{{ asset('public/font_end/assets/js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('public/font_end/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/back_end/custom_shipper/confirm_order.js') }}"></script>
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
</body>

</html>
