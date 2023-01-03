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
            font-size: 20px;
            font-weight: bold

        }
        body {
            font-family: DejaVu Sans, sans-serif;
        }
        .table td, .table th {
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="title">{{ $string_title }}</div>
    <table class="table table-bordered mt-20">
        <tr style="font-size: 15px">
            <th>STT</th>
            <th>Sản Phẩm</th>
            <th>Ngày Bắt Đầu Giảm Giá 1</th>
            <th>Ngày Kết Thúc Giảm Giá 1</th>
            <th>Lượng Giảm 1</th>
            <th>Ngày Bắt Đầu Giảm Giá 2</th>
            <th>Ngày Kết Thúc Giảm Giá 2</th>
            <th>Lượng Giảm 2</th>
        </tr>
        @php
             $stt = 1;
        @endphp
        @foreach ($all_discount as $discount)
            <tr>
                <td>{{ $stt++ }}</td>
                <td style="width: 30%">
                    @foreach ($all_product as $product)
                        @if ($product->discount_id == $discount->discount_id)
                            - {{ $product->product_name }}<br>
                        @endif
                    @endforeach
                </td>
                <td>
                    {{ date("d/m/Y H:i a", strtotime($discount->start_date_1)) }}
                </td>
                <td>
                    {{ date("d/m/Y H:i a", strtotime($discount->end_date_1)) }}
                </td>
                <td>
                    @if ($discount->condition_discount_1 != "")
                        @if ($discount->condition_discount_1 == 1)
                            -{{ $discount->amount_discount_1 }}%
                        @else
                            -{{ number_format($discount->amount_discount_1, 0, ',', '.') }}vnđ
                        @endif
                    @else
                        Null
                    @endif
                </td>
                <td>
                    {{ date("d/m/Y H:i a", strtotime($discount->start_date_2)) }}
                </td>
                <td>
                    {{ date("d/m/Y H:i a", strtotime($discount->end_date_2)) }}
                </td>
                <td>
                    @if ($discount->condition_discount_2 != "")
                        @if ($discount->condition_discount_2 == 1)
                            -{{ $discount->amount_discount_2 }}%
                        @else
                            -{{ number_format($discount->amount_discount_2, 0, ',', '.') }}vnđ
                        @endif
                    @else
                        Null
                    @endif
                </td>
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
