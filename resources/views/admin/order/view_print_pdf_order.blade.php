<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        .title{
            text-align: center;
            font-size: 25px;
            font-weight: bold

        }
        body {
            font-family: DejaVu Sans, sans-serif;
        }
    </style>
</head>
<body>
    <div class="title">{{ $string_title }}</div>
    <table class="table table-bordered mt-20" style="font-size: 15px">
        <tr>
            <th>STT</th>
            <th>Mã Đơn Hàng</th>
            <th>Đơn Giá</th>
            <th>Tên Khách Hàng</th>
            <th>Địa Chỉ Giao Hàng</th>
            <th>Hình Thức Thanh Toán</th>
            <th>Trạng Thái Đơn Hàng</th>
        </tr>
        @php
             $stt = 1;
        @endphp
        @foreach ($all_order as $order)
            <tr>
                <td>{{ $stt++ }}</td>
                <td>
                    {{ $order->order_code }}
                </td>
                <td>
                    {{ number_format($order->total_price,0,',','.') }}₫
                </td>
                <td>
                    {{ $order->trans_fullname }}
                </td>
                <td>
                    {{ $order->trans_address }}
                </td>
                <td>
                    {{ $order->payment_name }}
                </td>
                <td>
                    @foreach ($order_detail_status as $status)
                        @if ($status->order_id == $order->order_id)
                            @foreach ($status_order as $sta_order)
                                @if ($sta_order->status_id == $status->status_id)
                                    {{ $sta_order->status_name }}
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                </td>
                {{-- <td>
                    {{ date('d/m/Y H:i a', strtotime($product->create_at)) }}
                </td> --}}
            </tr>
        @endforeach
    </table>
    <div class="row">
        <div class="" style="float: right">Ngày xuất file: {{ date("d/m/Y") }}</div>
    </div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
