<div class="header-top bg-main hidden-xs">
    <div class="container">
        <div class="top-bar left">
            <ul class="horizontal-menu">
                <li><a href="mailto: radiushoakho@gmail.com"><i class="fa fa-envelope" aria-hidden="true"></i>radiushoakho@gmail.com</a></li>
                <li><a href="tel:091163513"><i class="fa fa-phone" aria-hidden="true"></i>Liên hệ hotline: 0911 635 153</a></li>
            </ul>
        </div>
        <div class="top-bar right" style="display: flex;">
            <ul class="social-list" style=" align-items: center; display: flex;">
                <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                <li><a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a></li>
            </ul>
            <ul class="horizontal-menu">
                @if (Session::get('customer_id'))
                    @php
                        $customer_id = Session::get('customer_id');
                        $image = App\Http\Controllers\CustomerController::image($customer_id);
                    @endphp
                    <li class="header__navbar-user">
                        <img src="{{ asset('public/upload/' . $image) }}" alt="" class="header__navbar-user-img">
                        <span class="header__navbar-user-name">{{ Session::get('username') }}</span>
                        <ul class="header__navbar-user-menu" style="z-index: 100;">
                            <li class="header__navbar-user-item">
                                <a href="{{ URL::to('user/account') }}">Tài khoản của tôi</a>
                            </li>
                            <li class="header__navbar-user-item">
                                <a href="{{ URL::to('user/order') }}">Đơn hàng</a>
                            </li>
                            <li class="header__navbar-user-item">
                                <a href="{{ URL::to('logout_client') }}">Đăng xuất</a>
                            </li>
                        </ul>
                    </li>
                @else
                    <li>
                        <a href="{{ URL::to('login_client') }}" class="login-link"><i class="biolife-icon icon-login"></i>Đăng nhập/</a>
                        <a href="{{ URL::to('register_client') }}" class="login-link">Đăng ký</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>
