<!DOCTYPE html>
<html>

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8">
    <title>Lấy lại mật khẩu</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/upload/logo-icon.svg') }}" />


    <!-- Site favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('public/back_end/vendors/images/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('public/back_end/vendors/images/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('public/back_end/vendors/images/favicon-16x16.png') }}">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/back_end/vendors/styles/core.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/back_end/vendors/styles/icon-font.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/back_end/vendors/styles/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/back_end/src/styles/custom.css') }}">
    <style>
        :root {
            --radius-color: #eb7e82;
        }

    </style>

</head>

<body class="login-page">
    <div class="login-header box-shadow">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div class="brand-logo">
                <a href="{{ URL::to('/') }}">
                    <img src="{{ asset('public/upload/logo-flower.svg') }}" alt="" style="height: 46px;">
                </a>
            </div>
            <div class="login-menu">
                <ul>
                    <li><a href="{{ URL::to('register_client') }}" style="color: var(--radius-color)">Đăng ký</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="login-wrap d-flex align-items-center flex-wrap justify-content-center" style="background-image: url('public/upload/background.jpeg'); background-size: 100% auto; background-position: center; background-repeat: no-repeat;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 col-lg-7">
                </div>
                <div class="col-md-6 col-lg-5">
                    <div class="login-box bg-white box-shadow border-radius-10">
                        <div class="login-title">
                            <h2 class="text-center" style="color: var(--radius-color)">Nhập mật khẩu mới</h2>
                        </div>
                        @if ($errors->any())
                            <div class="alert alert-danger alert-blog">{{ $errors->first() }}</div>
                        @endif
                        {{-- FORM --}}
                        <form action="{{ URL::to('process_reset_password/' . $customer_id) }}" method="post" style="text-align: center">
                            @csrf
                            <div class="input-group custom">
                                <input type="password" name="password" class="form-control form-control-lg" placeholder="Mật khẩu">
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="icon-copy dw dw-padlock"></i></span>
                                </div>
                            </div>
                            <div class="input-group custom">
                                <input type="password" name="password_confirmation" class="form-control form-control-lg" placeholder="Xác nhận lại mật khẩu">
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="icon-copy dw dw-padlock"></i></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="input-group mb-0 btn-login">
                                        <input type="submit" class="btn btn-lg btn-block" style="background-color: var(--radius-color); color:white;" value="Đổi mật khẩu" />
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- js -->
    <script src="{{ asset('public/back_end/vendors/scripts/core.js') }}"></script>
    <script src="{{ asset('public/back_end/vendors/scripts/script.min.js') }}"></script>
    <script src="{{ asset('public/back_end/vendors/scripts/process.js') }}"></script>
    <script src="{{ asset('public/back_end/vendors/scripts/layout-settings.js') }}"></script>
</body>

</html>
