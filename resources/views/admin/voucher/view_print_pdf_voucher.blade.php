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
        <tr>
            <th>STT</th>
            <th>Mã Voucher</th>
            <th>Tên Voucher</th>
            <th>Ngày Bắt Đầu</th>
            <th>Ngày Kết Thúc</th>
            <th>Số Lượng</th>
            <th>Mệnh Giá</th>
            <th>Tình Trạng</th>
        </tr>
        @php
            $stt = 0;
        @endphp
        @foreach ($all_voucher as $voucher)
            @php
                $stt++;
            @endphp
            <tr role="row" class="odd text-center">
                <td>{{ $stt }}</td>
                <td>
                    {{ $voucher->voucher_code }}
                </td>
                <td class="text-left">
                    {{ $voucher->voucher_name }}
                </td>
                <td>
                    {{ date('d-m-y H:i a', strtotime($voucher->start_date)) }}
                </td>
                <td>
                    {{ date('d-m-y H:i a', strtotime($voucher->end_date)) }} </td>
                <td>{{ $voucher->voucher_quantity }}</td>
                <td>{{ number_format($voucher->voucher_amount, 0, ',', '.') }}₫</td>
                <td>
                    @php
                        $now = Carbon\Carbon::now();
                    @endphp
                    @if ($voucher->start_date <= $now && $now <= $voucher->end_date && $voucher->voucher_quantity > 0)
                        <span>Đang áp
                            dụng</span>
                    @elseif ($voucher->start_date > $now)
                        <span>Chưa áp
                            dụng</span>
                    @else
                        <span>Ngưng áp
                            dụng</span>
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
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
