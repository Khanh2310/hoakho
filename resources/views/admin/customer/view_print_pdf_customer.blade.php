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
    <table class="table table-bordered mt-20" style="font-size: 15px">
        <tr role="row">
            <th>STT</th>
            <th>Họ Và Tên</th>
            <th>Số Điện Thoại</th>
            <th>Email</th>
            <th>Đơn Hàng Đã Mua</th>
            <th>Giới Tính</th>
        </tr>
        @php
            $stt = 0;
        @endphp
        @foreach ($all_customer as $customer)
            @php
                $stt++;
            @endphp
            <tr role="row" class="odd">
                <td>{{ $stt }}</td>
                <td>
                    <div class="weight-600">{{ $customer->username }}</div>
                </td>
                @if ($customer->customer_phone == '')
                    <td>Chưa cập nhật</td>
                @else
                    <td>{{ $customer->customer_phone }}</td>
                @endif
                <td>{{ $customer->email }}</td>
                <td>
                    @php
                        $count_order = 0;
                    @endphp
                    @foreach ($all_order as $order)
                        @if ($order->customer_id == $customer->customer_id)
                            @php
                                $count_order++;
                            @endphp
                        @endif
                    @endforeach
                    {{ $count_order }}
                </td>
                @if ($customer->customer_gender)
                    <td>{{ $customer->customer_gender }}</td>
                @else
                    <td>Chưa cập nhật</td>
                @endif
            </tr>
        @endforeach
    </table>
    <div class="row">
        <div class="" style="float: right">Ngày xuất file: {{ date('d/m/Y') }}</div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
</body>

</html>
