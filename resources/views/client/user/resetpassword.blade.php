<link rel="stylesheet" href="{{ asset('public/font_end/bootstrap/css/bootstrap.min.css') }}">
@extends('client.layout_account_client')
@section('content_body')
    <link rel="stylesheet" href="{{ asset('public/font_end/custom_account/user_sidebar_content.css') }}">
    <style>
        .btn:focus,
        .btn:active:focus,
        .btn.active:focus,
        .btn.focus,
        .btn:active.focus,
        .btn.active.focus {
            outline: none;
        }

    </style>
    <div class="container">
        <nav class="biolife-nav cus_breadcrumb">
            <ul>
                <li class="nav-item"><a href="{{ URL::to('/') }}" class="permal-link">Trang chủ</a></li>
                <li class="nav-item"><a href="{{ URL::to('user/account') }}" class="permal-link">Tài khoản</a></li>
                <li class="nav-item"><span class="current-page">Đổi mật khẩu</span></li>
            </ul>
        </nav>
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
                            <ul class="user-list-module">
                                <li class="user-module-item">
                                    <a href="{{ URL::to('user/account') }}" class="user-module-item--link">Hồ sơ</a>
                                </li>
                                <li class="user-module-item">
                                    <a href="{{ URL::to('user/address') }}" class="user-module-item--link">Địa chỉ</a>
                                </li>
                                <li class="user-module-item user-module-item--active">
                                    <a href="{{ URL::to('user/resetpassword') }}" class="user-module-item--link">Đổi mật khẩu</a>
                                </li>
                                <li class="user-module-item">
                                    <a href="{{ URL::to('user/order') }}" class="user-module-item--link">Đơn mua</a>
                                </li>
                                <li class="user-module-item">
                                    <a href="{{ URL::to('user/voucher') }}" class="user-module-item--link">Kho Voucher</a>
                                </li>
                            </ul>
                        </nav>
                    </div>

                    <!--content-user-->
                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12" style="margin-bottom: 32px;">
                        <div class="content__user" style="min-height: 300px;">
                            <div class="content__user-heading">
                                <span class="user-heading-title">Đổi mật khẩu</span>
                            </div>
                            <form name="form_update_resetpassword">
                                @csrf
                                <div class="content__user-resetpassword">
                                    <div class="user-password">
                                        <span>Mật khẩu hiện tại</span>
                                        <input class="custom-input-user password_old" type="password" name="password_old" style="padding: 7px 8px;">
                                    </div>
                                    <div class="forget-password">
                                        <a href="{{ URL::to('mail_reset_password') }}">Quên mật khẩu?</a>
                                    </div>
                                    <div class="user-password">
                                        <span>Mật khẩu mới</span>
                                        <input class="custom-input-user password_new" type="password" name="password_new" style="padding: 7px 8px;">
                                    </div>
                                    <div class="user-password">
                                        <span>Xác nhận mật khẩu</span>
                                        <input class="custom-input-user password_new_confirmation" type="password" name="password_new_confirmation" style="padding: 7px 8px;">
                                    </div>
                                    <button type="button" class="btn-update-user btn_confirm_resetpassword">Xác Nhận</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('public/font_end/assets/js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('public/font_end/custom_account/resetpassword.js') }}"></script>
@endsection
