@extends('client.layout_client_check_out')
@section('content_body')
    <link rel="stylesheet" href="{{ asset('public/font_end/custom/check_out_success.css') }}">
    <div class="content-body">
        <div class="container pd-40 center">
            <div class="content-img">
                <img class="img-success" src="{{ asset('public/upload/checked.png') }}" alt="">
                <h4 style="font-weight: bold">Đặt hàng thành công</h4>
            </div>
            <div class="content-bill">
                <div class="content-text-bill">

                    @if (Session::get('customer_id'))
                        <div class="" style="font-weight: bold; font-size: 16px">Chào {{ Session::get('username') }},</div>
                    @endif
                    <div class="" style="padding-bottom: 10px">Chúc mừng bạn đã đặt hàng thành công sản phẩm của <strong>RADIUS Hoa Khô</strong></div>
                    <div class="space-between">
                        <div class="txt">Mã đơn hàng:</div>
                        <div class=""><strong>#{{ $orders->order_code }}</strong></div>
                    </div>
                    <div class="space-between">
                        <div class="txt">Phương thức thanh toán:</div>
                        <div class="">
                            @if ($payment_method == 0)
                                <strong>Thanh toán khi nhận hàng</strong>
                            @else
                                <strong>Thanh toán trực tuyến paypal</strong>
                            @endif
                        </div>
                    </div>
                    <div class="space-between">
                        <div class="txt">Thời gian dự kiến giao hàng</div>
                        <div class=""><strong>2-3 ngày</strong></div>
                    </div>
                    <div class="space-between">
                        <div class="txt">Tổng thanh toán</div>
                        <div class=""><strong style="color: var(--radius-color);">{{ number_format($summary_total_order, 0, ',', '.') }} vnđ</strong></div>
                    </div>
                    <div class="space-between">
                        <div class="txt">Tình trạng</div>
                        <div class="">
                            @if ($status == 0)
                                <strong style="color: var(--radius-color);">Chưa thanh toán</strong>
                            @else
                                <strong style="color: var(--radius-color);">Đã thanh toán</strong>
                            @endif

                        </div>
                    </div>
                    <div class="line"></div>
                    <div class="" style="font-weight: bold">Mọi thông tin về đơn hàng sẽ được gửi tới email của bạn,
                        vui lòng kiểm tra email để biết thêm chi tiết.</div>
                    <div class="" style="font-weight: bold">Cảm ơn bạn đã tin tưởng và giao dịch tại RADIUS Hoa Khô</div>
                    <div class="" style="font-weight: bold; padding-top: 15px">Ban quản trị RADIUS Hoa Khô</div>
                    <div class="content-btn" style="display: flex; justify-content: center">
                        <a href="{{ URL::to('/') }}" class="btn btn-radius-color" style="margin: 5px">Tiếp tục mua sắm</a>
                        <a href="{{ URL::to('user/order/' . $orders->order_id) }}" class="btn btn-default" style="margin: 5px">Chi tiết đơn hàng
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
