<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }
        table{
            margin: 20px;
            padding: 10px;
            border-collapse: collapse;
            font-size: 16px;

        }
        tr{
            border-top: 1px solid black !important;;
        }
        td{
            padding: 10px;
        }
        br{
            padding-top: 4px;
        }
    </style>
</head>
<body>
    <table class="table table-bordered" style="border: 1px solid black">
        <tr>
            <td colspan="2" style="text-align: right;">
                <p>Mã đơn hàng: {{ $order_pdf->order_code }}</p>
            </td>
        </tr>
        <tr>
            <td style="border-right: 1px solid black">
                <b>Từ</b> <br>
                <p>MKU FOOD Trường Đại Học Cửu Long</p>
                Quốc Lộ 1A, Huyện Long Hồ, Phú Quới, Long Hồ, Vĩnh Long <br>
                SĐT: 0270 3831 155
            </td>
            <td>
                <b>Đến</b> <br>
                <p><b>{{ $trans->trans_fullname }}</b></p>
                <b>{{ $trans->trans_address }}</b><br>
                <b>SĐT: {{ $trans->trans_phone }}</b>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                Nội dung đơn hàng:(Tổng SL sản phẩm {{ count($order_item) }}) <br>
                @foreach ($order_item as $item)
                    <b>- {{ $item->product_name }}</b>. <b>SL:{{ $item->quantity_product }}</b><br>
                @endforeach
            </td>
        </tr>
        <tr>
            <td>
                <div class="price-re">
                    <div>Tiền thu người nhận</div>
                    <b style="font-size: 20px; text-align: center">{{ number_format($order_pdf->total_price, 0, ',', '.')  }}₫</b>
                </div>
            </td>
            <td>
                <div class="sign">
                    <div class="" style="text-align: center">Chữ ký người nhận</div>
                    <div class="place-sign" style="height: 100px;">

                    </div>
                </div>
            </td>
        </tr>
    </table>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>

