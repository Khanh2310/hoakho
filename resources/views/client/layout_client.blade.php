<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RADIUS Hoa Khô</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/upload/logo-icon.svg') }}" />
    <link rel="stylesheet" href="{{ asset('public/font_end/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/font_end/assets/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/font_end/assets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/font_end/assets/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('public/font_end/assets/css/slick.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/font_end/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('public/font_end/custom/sweet.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/back_end/vendors/styles/icon-font.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/font_end/assets/css/main-color03-green.css') }}">

    <link rel="stylesheet" href="{{ asset('public/font_end/custom_account/event_hover_account.css') }}">
    <link rel="stylesheet" href="{{ asset('public/font_end/custom_account/user_sidebar_content.css') }}">
    <link rel="stylesheet" href="{{ asset('public/font_end/custom/custom_discount.css') }}">
    <link rel="stylesheet" href="{{ asset('public/font_end/custom_ui/css/custom_header.css') }}">
    <link rel="stylesheet" href="{{ asset('public/font_end/custom_ui/css/design_search_auto.css') }}">

    {{-- responsive --}}
    <link rel="stylesheet" href="{{ asset('public/font_end/responsive/mobile.css') }}">
    <style>
        @media (min-width: 1200px) {
            .container {
                width: 1200px;
            }

            .main-content {
                background-color: rgb(245, 245, 245);
            }
        }

        body {
            font-family: 'Roboto', sans-serif !important;
        }

        .add-to-cart-btn:hover {
            color: #fff !important;
        }

        .btn-radius-color {
            color: #fff;
            background-color: var(--radius-color);
            border-color: var(--radius-color);
        }

        .btn-radius-color:hover {
            color: #fff;
            background-color: #444444 !important;
            border-color: #444444 !important;
        }

        .btn-radius-color:active {
            color: #fff;
            background-color: var(--radius-color);
            border-color: var(--radius-color);
        }

        .btn-radius-color:visited {
            color: #fff;
            background-color: var(--radius-color);
            border-color: var(--radius-color);
        }

    </style>
</head>

<body class="biolife-body">
    <!-- Preloader -->
    {{-- @include('client.layout.header_middle.preload') --}}
    <!-- HEADER -->
    <header id="header" class="header-area style-01 layout-03" style="border-bottom: 1px solid rgba(0, 0, 0, 0.09);">
        {{-- HEADER TOP --}}
        @include('client.layout.header_top.header_top')
        {{-- ACCOUNT MOBILE --}}
        <div class="mobile">
            @include('client.layout.responsive_mobile.account_mobile')
        </div>
        {{-- LOGO --}}
        {{-- HEADER MIDDLE --}}
        <div class="header-middle biolife-sticky-object ">
            <div class="container">
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-md-6 col-xs-6">
                        <a href="{{ URL::to('/') }}" class="biolife-logo">
                            <img src="{{ asset('public/upload/logo-flower.svg') }}" alt="biolife logo" style="height: 46px;">
                        </a>
                    </div>
                    {{-- NAV PAGES --}}
                    {{-- @include('client.layout.header_middle.nav_pages') --}}
                    @include('client.layout.header_bottom.search')
                    <div class="col-lg-2 col-md-2 col-md-6 col-xs-6">
                        <div class="biolife-cart-info">
                            {{-- RESPONSIVE SEARCH MOBILE --}}
                            {{-- @include('client.layout.header_middle.search_responsive') --}}
                            {{-- WISH LISH --}}
                            @include('client.layout.header_middle.wishlish')
                            {{-- MINI CART --}}
                            @include('client.layout.header_middle.mini_cart')
                            {{-- RESPONSIVE FOR MOBILE --}}
                            <div class="mobile-menu-toggle">
                                <a class="btn-toggle" data-object="open-mobile-menu" href="javascript:void(0)">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @include('client.layout.header_middle.nav_pages')
                </div>
            </div>
        </div>
    </header>

    <!-- Page Contain -->
    <div class="page-contain">

        <!-- Main content -->
        <div id="main-content" class="main-content">
            <!--Block 01: Main Slide-->
            @yield('slider_view_client')

            <!--Block 02: Banners-->
            @yield('banner_view_client')

            <!--Block 03: Product Tabs-->
            @yield('product_tap_view_client')

            <!--Block 04: Banner Promotion 01-->
            @yield('promotion_view_client')

            <!--Block 05: Banner promotion 02-->
            @yield('promotion2_view_client')
            <!--Block 07: Brands-->
            @yield('brands_view_client')

            <!--Block 08: Blog Posts-->
            @yield('blog_view_client')

            <!--Block 06: Products-->
            @yield('top_rate_product_view_client')

            @yield('content_body')

        </div>
    </div>

    <!-- FOOTER -->
    @include('client.layout.footer.footer')

    {{-- quickview --}}
    {{-- @include('client.layout.body.quickview_popup'); --}}

    <!-- Scroll Top Button -->
    <a class="btn-scroll-top"><i class="biolife-icon icon-left-arrow"></i></a>
    {{--  --}}
    <!-- Messenger Plugin chat Code -->
    <div id="fb-root"></div>

    <!-- Your Plugin chat code -->
    <div id="fb-customer-chat" class="fb-customerchat">
    </div>

    <script>
        var chatbox = document.getElementById('fb-customer-chat');
        chatbox.setAttribute("page_id", "102118232309471");
        chatbox.setAttribute("attribution", "biz_inbox");

        window.fbAsyncInit = function() {
            FB.init({
                xfbml: true,
                version: 'v12.0'
            });
        };

        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
    {{--  --}}
    <script src="{{ asset('public/font_end/assets/js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('public/font_end/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/font_end/assets/js/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('public/font_end/assets/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('public/font_end/assets/js/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('public/font_end/assets/js/slick.min.js') }}"></script>
    <script src="{{ asset('public/font_end/assets/js/biolife.framework.js') }}"></script>
    <script src="{{ asset('public/font_end/assets/js/functions.js') }}"></script>
    <script src="{{ asset('public/font_end/custom/sweet.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    {{--  --}}
    <script src="{{ asset('public/font_end/custom/custom.js') }}"></script>
    {{-- <script src="{{ asset('public/font_end/custom/rating_comment.js') }}"></script> --}}
    <script src="{{ asset('public/font_end/custom/update_cart_ajax.js') }}"></script>
    <script src="{{ asset('public/font_end/custom_ui/js/ajax_wish_list.js') }}"></script>
    <script src="{{ asset('public/back_end/src/scripts/upperFirstKey.js') }}"></script>
    <script src="{{ asset('public/back_end/fix/js/format_name_input.js') }}"></script>
    <script src="{{ asset('public/back_end/src/scripts/checkName.js') }}"></script>
    <script src="{{ asset('public/font_end/custom_ui/js/sort_ajax_shop.js') }}"></script>
    <script src="{{ asset('public/font_end/custom_ui/js/ajax_choose_search.js') }}"></script>
    <script src="{{ asset('public/font_end/custom/mini_detail_product.js') }}"></script>

    {{-- check out custom
    <script src="{{ asset('public/font_end/custom/checkout_custom.js') }}"></script> --}}

    {{--  --}}
    <script src="{{ asset('public/back_end/src/scripts/upload_image.js') }}"></script>
</body>

</html>
