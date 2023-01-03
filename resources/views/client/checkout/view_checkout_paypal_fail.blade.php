@extends('client.layout_client_check_out')
@section('content_body')
    <link rel="stylesheet" href="{{ asset('public/font_end/custom/check_out_success.css') }}">
    <div class="content-body">
        <div class="container pd-40 center">
            <div class="content-img">
                <img class="img-success" src="{{ asset('public/upload/checked.png') }}" alt="">
                <h4 style="font-weight: bold">Thanh Toán Thất Bại</h4>
            </div>
            <div class="content-bill">
                <div class="content-text-bill">

                    @if (Session::get('customer_id'))
                        <div class="" style="font-weight: bold; font-size: 16px">Chào {{ Session::get('username') }},</div>
                    @endif
                    <div class="" style="padding-bottom: 10px">Bạn đã hủy thanh toán đơn hàng tại <strong>RADIUS Hoa Khô</strong></div>
                    <div class="content-btn" style="display: flex; justify-content: center">
                        <a href="{{ URL::to('show_cart') }}" class="btn btn-radius-color" style="margin: 5px">Quay Lại Giỏ Hàng</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
