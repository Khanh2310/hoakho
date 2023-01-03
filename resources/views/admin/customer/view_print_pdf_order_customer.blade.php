<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">
    <style>
        .title {
            text-align: center;
            font-size: 20px;
            font-weight: bold
        }

        body {
            font-family: DejaVu Sans, sans-serif;
        }

        .table td,
        .table th {
            font-size: 10px;
        }

    </style>
</head>

<body>
    <h2 class="title">{{ $string_title }}</h2>
    @php
        $stt = 0;
    @endphp
    @foreach ($all_order as $order)
        <table class="table table-bordered mt-20" style="font-size: 15px">
            <tr colspan="3">
                <td>Mã đơn hàng: {{ $order->order_code }}</td>
                <td>{{ date('d-m-y H:i a', strtotime($order->create_at)) }}</td>
                <td>
                    @foreach ($all_order_detail_status as $order_detail_status)
                        @if ($order->order_id == $order_detail_status->order_id && $order_detail_status->status == 1)
                            @foreach ($status_order as $status)
                                @if ($status->status_id == $order_detail_status->status_id)
                                    @if ($order_detail_status->status_id == 1)
                                        <span>{{ $status->status_name }}</span>
                                    @elseif($order_detail_status->status_id == 2)
                                        <span>{{ $status->status_name }}</span>
                                    @elseif($order_detail_status->status_id == 3)
                                        <span>{{ $status->status_name }}</span>
                                    @elseif($order_detail_status->status_id == 4)
                                        <span>{{ $status->status_name }}</span>
                                    @elseif($order_detail_status->status_id == 5)
                                        <span>{{ $status->status_name }}</span>
                                    @endif
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <div>
                        @foreach ($trans as $tr)
                            @if ($order->trans_id == $tr->trans_id)
                                <div>
                                    <span>Người nhận</span>
                                    <span>{{ $tr->trans_fullname }}</span>
                                </div>
                                <div>
                                    <span>Số điện thoại</span>
                                    <span>{{ $tr->trans_phone }}</span>
                                </div>
                                <div>
                                    <span>Địa chỉ giao hàng</span>
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
            @foreach ($all_order_item as $order_item)
                @if ($order_item->order_id == $order->order_id)
                    <tr>
                        <td>
                            @foreach ($all_product as $product)
                                @if ($order_item->product_id == $product->product_id)
                                    <div class="txt">
                                        <div class="weight-600">{{ $product->product_name }}</div>
                                    </div>
                                @endif
                            @endforeach
                        </td>
                        <td class="text-center">{{ $order_item->quantity_product }}</td>
                        <td class="text-center">{{ number_format($order_item->price_product, 0, ',', '.') }} ₫
                            </th>
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
                    <div>
                        @foreach ($payment_method as $pay)
                            @if ($pay->payment_id == $order->payment_id)
                                <span>{{ $pay->payment_name }}</span>
                            @endif
                        @endforeach
                        <span>Tổng giá đơn hàng:</span>
                    </div>
                </td>
                <td style="font-size: 14px">{{ number_format($order->total_price, 0, ',', '.') }} ₫</td>
            </tr>
        </table>
    @endforeach
    <div class="row">
        <div class="" style=" float: right">Ngày xuất file: {{ date('d/m/Y') }}</div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
</body>

</html>
