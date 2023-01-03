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
    <h2 class="title">{{ $string_title }}</h2>
    <table class="table table-bordered mt-20" style="font-size: 15px">
        <tr>
            <th>STT</th>
            <th>Tên</th>
            <th>Giá</th>
            <th>Trong Kho</th>
            <th>Đã Bán</th>
            <th>Đánh Giá</th>
            <th>Ngày Thêm</th>
        </tr>
        @php
             $stt = 1;
        @endphp
        @foreach ($data as $product)
        @php
            $price_discount = App\Http\Controllers\HomeClientController::check_price_discount($product->product_id);
            $info_rating_saled = App\Http\Controllers\HomeClientController::info_rating_saled($product->product_id);
        @endphp
            <tr>
                <td>{{ $stt++ }}</td>
                <td>
                    {{ $product->product_name }}
                </td>
                <td>
                    {{ $price_discount->price_now }}₫
                </td>
                <td>
                    {{ $product->total_quantity_product }}
                </td>
                <td>
                    {{ $info_rating_saled->count_product_saled }}
                </td>
                <td>
                    {{ $info_rating_saled->avg_rating }} sao
                </td>
                <td>
                    {{ date('d/m/Y H:i a', strtotime($product->create_at)) }}
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
