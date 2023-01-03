<!DOCTYPE html>
<html>

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8">
    <title>Đăng nhập</title>
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

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-119386393-1"></script>
</head>

<body class="login-page">
    <div class="login-header box-shadow">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div class="brand-logo">
                <a href="{{ URL::to('/admin') }}">
                    <img src="{{ asset('public/upload/logo-flower.svg') }}" alt="" style="height: 46px;">
                </a>
            </div>
            {{-- <div class="login-menu">
				<ul>
					<li><a href="register.html">Register</a></li>
				</ul>
			</div> --}}
        </div>
    </div>
    <div class="login-wrap d-flex align-items-center flex-wrap justify-content-center" style="background-image: url('public/upload/background.jpeg'); background-size: 100% auto; background-position: center; background-repeat: no-repeat;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 col-lg-7">
                </div>
                <div class="col-md-6 col-lg-5">
                    <div class="login-box bg-white box-shadow border-radius-10">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-blog" style="text-align: center">{{ $errors->first() }}</div>
                        @endif
                        <div class="login-title">
                            <h2 class="text-center" style="color: #1b3133">Đăng nhập vào hệ thống</h2>
                        </div>
                        {{-- FORM --}}
                        <form action="{{ URL::to('process_login') }}" method="post" style="text-align: center">
                            @csrf
                            <div class="select-role">
                                {{-- <div class="btn-group-toggle btn-group d-inline-flex justify-content-center" data-toggle="buttons">
									<label class="btn active">
										<input type="radio" name="options" id="admin">
										<div class="icon">
                                            <img src="{{ asset('public/back_end/vendors/images/briefcase.svg') }}" class="svg" alt="">
                                        </div>
										<span>Hi !</span>
										Quản Lý
									</label>
									<label class="btn">
										<input type="radio" name="options" id="user">
										<div class="icon">
                                            <img src="{{ asset('public/back_end/vendors/images/person.svg') }}" class="svg" alt="">
                                        </div>
										<span>Hi !</span>
										Nhân Viên
									</label>
								</div> --}}
                            </div>
                            <div class="input-group custom">
                                <input type="email" name="email" class="form-control form-control-lg" placeholder="Email" style="">
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
                                </div>
                            </div>
                            <div class="input-group custom">
                                <input type="password" name="password" class="form-control form-control-lg" placeholder="**********">
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="input-group mb-0">
                                        <!--
           use code for form submit
           <input class="btn btn-primary btn-lg btn-block" type="submit" value="Sign In">
          -->
                                        <input type="submit" class="btn btn-primary btn-lg btn-block" style="background-color: #1b3133; border: none" value="Đăng nhập" />
                                    </div>
                                    {{-- <div class="font-16 weight-600 pt-10 pb-10 text-center" data-color="#707373">OR</div>
									<div class="input-group mb-0">
										<a class="btn btn-outline-primary btn-lg btn-block" href="register.html">Register To Create Account</a>
									</div> --}}
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
