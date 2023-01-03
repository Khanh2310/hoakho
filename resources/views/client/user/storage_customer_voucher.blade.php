@extends('client.layout_account_client')
@section('content_body')
    <link rel="stylesheet" href="{{ asset('public/font_end/custom_account/user_sidebar_content.css') }}">
    <link rel="stylesheet" href="{{ asset('public/font_end/custom_account/storage_voucher.css') }}">
    <style>
        .btn:focus,
        .btn:active:focus,
        .btn.active:focus,
        .btn.focus,
        .btn:active.focus,
        .btn.active.focus {
            outline: none;
        }

        .text {
            overflow: hidden;
            height: 35px;
            line-height: 18px;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            /* number of lines to show */
            -webkit-box-orient: vertical;
        }

    </style>
    <div class="container">
        <div class="container laptop">
            <nav class="biolife-nav cus_breadcrumb">
                <ul>
                    <li class="nav-item"><a href="{{ URL::to('/') }}" class="permal-link">Trang chủ</a></li>
                    <li class="nav-item"><a href="{{ URL::to('user/account') }}" class="permal-link">Tài khoản</a></li>
                    <li class="nav-item"><span class="current-page">Hồ sơ</span></li>
                </ul>
            </nav>
        </div>
    </div>
    <div class="page-contain">

        <!-- Main content -->
        <div id="main-content" class="main-content">
            <div class="container">
                <div class="row">

                    <!--sidebar-->
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <nav class="user">
                            <div class="user-heading">
                                @if (Session::get('customer_id'))
                                    <img src="{{ asset('public/upload/' . $customer_info->customer_avt) }}" alt="" class="user-img">
                                @else
                                    <img src="{{ asset('public/upload/no_image.png') }}" alt="" class="user-img">
                                @endif

                                @if (Session::get('customer_id'))
                                    <span class="user-name">{{ $customer->username }}</span>
                                @else
                                    <span class="user-name">Unknown</span>
                                @endif
                            </div>
                            <div class="laptop">
                                <ul class="user-list-module">
                                    <li class="user-module-item">
                                        <a href="{{ URL::to('user/account') }}" class="user-module-item--link">Hồ sơ</a>
                                    </li>
                                    <li class="user-module-item">
                                        <a href="{{ URL::to('user/address') }}" class="user-module-item--link">Địa chỉ</a>
                                    </li>
                                    <li class="user-module-item">
                                        <a href="{{ URL::to('user/resetpassword') }}" class="user-module-item--link">Đổi mật
                                            khẩu</a>
                                    </li>
                                    <li class="user-module-item">
                                        <a href="{{ URL::to('user/order') }}" class="user-module-item--link">Đơn mua</a>
                                    </li>
                                    <li class="user-module-item user-module-item--active">
                                        <a href="{{ URL::to('user/voucher') }}" class="user-module-item--link">Kho
                                            Voucher</a>
                                    </li>
                                </ul>
                            </div>
                            {{-- responsive mobile --}}
                            <div class="mobile">
                                <div class="content-nav-account" style="display: flex; justify-content: space-between; padding: 5px 0px 10px 0px">
                                    <a href="{{ URL::to('user/account') }}" class="cus_btn">Hồ sơ</a>
                                    <a href="{{ URL::to('user/address') }}" class="cus_btn">Địa chỉ</a>
                                    <a href="{{ URL::to('user/order') }}" class="cus_btn">Đơn mua</a>
                                    <a href="{{ URL::to('user/voucher') }}" class="cus_btn active_account">Kho voucher</a>
                                </div>
                            </div>
                        </nav>
                    </div>

                    <!--content-user-->
                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12" style="margin-bottom: 32px;">
                        <div class="content__voucher">
                            <div class="content__voucher-heading">
                                <span class="voucher-heading-title">Voucher của bạn</span>
                            </div>
                            <div class="container__voucher-list">
                                @if (count($storage_customer_voucher) > 0)
                                    @foreach ($storage_customer_voucher as $voucher)
                                        <div class="container__voucher-item">
                                            <div class="container__voucher-item--left">
                                                <div class="voucher-item--left-img">
                                                    <img src="{{ asset('public/upload/voucher_image.png') }}" alt="">
                                                </div>
                                                <div class="voucher__item--left-name" style="font-size: 10px;">
                                                    RADIUS Hoa Khô
                                                </div>
                                                <div class="_2t7jNq _3LWUvt"></div>
                                            </div>
                                            <div class="container__voucher-item--right">
                                                <div class="voucher-item--right-info">
                                                    <div class="voucher-item--right-info-name text">
                                                        {{ $voucher->voucher_name }}
                                                    </div>
                                                    <div class="voucher-item--right-info-end-date">
                                                        HSD: {{ date('d/m/Y', strtotime($voucher->end_date)) }}
                                                    </div>
                                                </div>
                                                <div class="voucher-item--right-btn">
                                                    <a href="{{ URL::to('product_detail/' . $voucher->product_id) }}">Dùng ngay</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else

                                    <div class="div_no_voucher">
                                        <span>
                                            Bạn chưa có voucher nào!
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('public/font_end/assets/js/jquery-3.4.1.min.js') }}"></script>
@endsection
