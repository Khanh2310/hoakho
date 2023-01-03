<div class="col-lg-12 col-md-12 hidden-sm hidden-xs">
    <div class="col-lg-2 col-md-2 col-md-6 col-xs-6"></div>
    <div class="col-lg-8 col-md-8 col-md-6 col-xs-6" style="position: relative">
        <div class="primary-menu">
            <ul class="menu biolife-menu clone-main-menu clone-primary-menu" id="primary-menu" data-menuname="main menu">
                <li class="menu-item"><a href="{{ URL::to('/') }}">Trang chủ</a></li>
                <li class="menu-item">
                    <a href="{{ URL::to('shop_product') }}" class="menu-name" data-title="Shop" >Cửa hàng</a>
                </li>
                <li class="menu-item">
                    <a href="{{ URL::to('contact_us') }}" class="menu-name" data-title="Shop" >Liên hệ</a>
                </li>
                <li class="menu-item">
                    <a href="{{ URL::to('terms_conditions') }}" class="menu-name" data-title="Shop" >Chính sách và điều khoản</a>
                </li>

            </ul>
        </div>
        @include('client.layout.header_middle.auto_complete_search')
    </div>
    <div class="col-lg-2 col-md-2 col-md-6 col-xs-6">
    </div>
</div>
