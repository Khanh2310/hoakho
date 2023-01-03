<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>

    </style>
</head>
<body>
        <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" id="form_paypal" method="post">

            <input type="hidden" name="business" value="sb-8vpav6055059@business.example.com">

            <!-- tham số cmd có giá trị _xclick chỉ rõ cho paypal biết là người dùng nhất nút thanh toán -->
            <input type="hidden" name="cmd" value="_xclick">

            <!-- thông tin mua hàng -->
            <input type="hidden" name="item_name" value="HoaDonMuaHang">

             <input type="hidden" name="amount" placeholder="Nhập số tiền vào"
            value="{{ $vnd_to_usd }}">

            <!-- loại tiền -->
            <input type="hidden" name="currency_code" value="USD">

            <input type="hidden" name="return" value='{{ URL::to('view_checkout_paypal_success/'.$payment_method.'/'.$summary_total_order.'/'.$status.'/'.$orders->order_code) }}'>

            <input type="hidden" name="cancel_return" value="{{ URL::to('view_checkout_paypal_fail/'.$orders->order_id) }}">

            <input type="submit" id="papal_click" name="submit" style="opacity: 0">
        </form>
        <script src="{{ asset('public/font_end/assets/js/jquery-3.4.1.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('#papal_click').click();
        });
    </script>
</body>
</html>
