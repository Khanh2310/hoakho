<!DOCTYPE html>
<html>

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8">
    <title>Xác nhận tài khoản thành công</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/upload/logo-icon.svg') }}" />

    <!-- Site favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="vendors/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="vendors/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="vendors/images/favicon-16x16.png">

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

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-119386393-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-119386393-1');
    </script>
</head>

<body>
    <div class="error-page d-flex align-items-center flex-wrap justify-content-center pd-20">
        <div class="pd-10">
            <div class="error-page-wrap text-center">
                <h2 class="pd-30">Bạn đã đăng ký thành công!</h2>
                <p>Vui lòng kiểm tra lại email để xác thực tài khoản.<br> Sau khi kích hoạt tài khoản qua email, bạn sẽ được trải nghiệm mua sắm tại RADIUS Hoa Khô.<br>Chúc bạn một ngày vui vẻ!</p>
                <div class="pt-20 mx-auto max-width-200">
                    <a href="https://mail.google.com/" class="btn btn-block btn-lg" style="background-color: var(--radius-color); color: white">Chuyển đến email</a>
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
