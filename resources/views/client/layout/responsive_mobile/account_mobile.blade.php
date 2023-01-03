<div class="row">
    <div class="col-12">
        <div
            class="top-bar right"
            style="display: flex; justify-content: right; padding-right: 27px">
            <ul class="horizontal-menu" style="list-style-type: none">
                @if (Session::get('customer_id'))
                    @php
                        $customer_id = Session::get('customer_id');
                        $image = App\Http\Controllers\CustomerController::image($customer_id);
                    @endphp
                    <li class="header__navbar-user">
                        <a href="{{ URL::to('user/account') }}">
                            <img src="{{ asset('public/upload/' . $image) }}" alt="" class="header__navbar-user-img">
                            <span class="header__navbar-user-name">{{ Session::get('username') }}</span>
                        </a>

                    </li>
                @else
                    <li>
                        <a href="{{ URL::to('login_client') }}" class="login-link"><i
                                class="biolife-icon icon-login"></i>Đăng nhập/</a>
                        <a href="{{ URL::to('register_client') }}" class="login-link">Đăng ký</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>

