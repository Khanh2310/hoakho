<link rel="stylesheet" href="{{ asset('public/font_end/custom_account/user_sidebar_content.css') }}">
@extends('client.layout_account_client')
@section('content_body')
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

    <div class="container laptop">
        <nav class="biolife-nav cus_breadcrumb">
            <ul>
                <li class="nav-item"><a href="{{ URL::to('/') }}" class="permal-link">Trang chủ</a></li>
                <li class="nav-item"><a href="{{ URL::to('user/account') }}" class="permal-link">Tài khoản</a></li>
                <li class="nav-item"><span class="current-page">Hồ sơ</span></li>
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
                            <div class="laptop">
                                <ul class="user-list-module">
                                    <li class="user-module-item user-module-item--active">
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
                                    <li class="user-module-item">
                                        <a href="{{ URL::to('user/voucher') }}" class="user-module-item--link">Kho
                                            Voucher</a>
                                    </li>
                                </ul>
                            </div>
                            {{-- responsive mobile --}}
                            <div class="mobile">
                                <div class="content-nav-account" style="display: flex; justify-content: space-between; padding: 5px 0px 10px 0px">
                                    <a href="{{ URL::to('user/account') }}" class="cus_btn active_account">
                                        Hồ sơ
                                    </a>
                                    <a href="{{ URL::to('user/address') }}" class="cus_btn">Địa chỉ</a>
                                    <a href="{{ URL::to('user/order') }}" class="cus_btn">Đơn mua</a>
                                    <a href="{{ URL::to('user/voucher') }}" class="cus_btn">Kho voucher</a>
                                </div>
                            </div>
                        </nav>
                    </div>

                    <!--content-user-->
                    {{-- laptop --}}

                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12" style="height:500px; margin-bottom: 32px;">
                        <div class="content__user">
                            <div class="content__user-heading">
                                <span class="user-heading-title">Thông tin cá nhân</span>
                            </div>
                            <form enctype="multipart/form-data" id="formUpdateAccount">
                                @csrf
                                <div class="content__user-profile">
                                    <div class="user-profile">
                                        <div class="user-profile-name">
                                            <span>Tên đăng nhập</span>
                                            <label>{{ $customer->username }}</label>
                                        </div>
                                        <div class="user-profile-fullname">
                                            <span>Họ và Tên</span>
                                            <input class="custom-input-user upper_val customer_fullname check_format_name_input" type="text" name="customer_fullname" value="{{ $customer_info->customer_fullname }}" onblur="return upberFirstKey()"
                                                style="padding: 7px 8px;">
                                        </div>
                                        <div class="user-profile-email">
                                            <span>Email</span>
                                            <input class="custom-input-user" type="text" name="email" value="{{ $customer->email }}" readonly style="padding: 7px 8px;">
                                        </div>
                                        <div class="user-profile-phone">
                                            <span>Số điện thoại</span>
                                            <input class="custom-input-user customer_phone" type="text" name="customer_phone" value="{{ $customer_info->customer_phone }}" style="padding: 7px 8px;">
                                        </div>
                                        <div class="user-profile-gender">
                                            <span>Giới tính</span>
                                            <div class="radio-gender">
                                                <input class="gender_checked customer_gender" type="radio" name="customer_gender" @if ($customer_info->customer_gender == 'Nam')
                                                checked="checked"
                                                @endif
                                                value="Nam">
                                                <label>Nam</label><br>
                                            </div>
                                            <div class="radio-gender">
                                                <input type="radio" class="customer_gender" name="customer_gender" @if ($customer_info->customer_gender == 'Nu')
                                                checked="checked"
                                                @endif
                                                value="Nu">
                                                <label>Nữ</label><br>
                                            </div>
                                            <div class="radio-gender">
                                                <input type="radio" class="customer_gender" name="customer_gender" @if ($customer_info->customer_gender == 'Khac')
                                                checked="checked"
                                                @endif
                                                value="Khac">
                                                <label>Khác</label>
                                            </div>
                                        </div>
                                        <div class="user-profile-phone">
                                            <span>Ngày sinh</span>
                                            <input class="custom-input-user customer_birthday" type="date" name="customer_birthday" value="{{ $customer_info->customer_birthday }}" style="padding: 7px 8px;">
                                        </div>
                                        <button type="button" class="btn-update-user btn_update_info_account">Lưu</button>
                                    </div>
                                    <div class="user-upload-img">
                                        <div id="content_image_upload">
                                            <img src="{{ asset('public/upload/' . $customer_info->customer_avt) }}" class="img-upload" alt="hình ảnh" id="image_upload">
                                        </div>
                                        <div class="input-upload-img" style="text-align: center;">
                                            {{-- <img src="{{ asset('public/upload/upimage.png') }}" height="50px" width="50px" alt="" style="cursor: pointer;"> --}}
                                            <label for="file_upload" class="btn" style="    color: #fff; background-color: var(--radius-color);">Chọn Ảnh</label>
                                            <input type="file" name="customer_avt" id="file_upload" onchange="return uploadhinh()" class="custom-file-input customer_avt file_upload" style="width: 220px; opacity: 0;">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('public/font_end/assets/js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('public/font_end/custom_account/update_info_account.js') }}"></script>
@endsection
