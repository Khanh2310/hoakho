<div class="user-info-dropdown">
    <div class="dropdown">
        <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
            <span class="user-icon">

                @if (Session::get('admin_image'))
                    <img src="{{ asset('public/upload/' . Session::get('admin_image')) }}" style="width: 50px; height: 50px;" alt="">
                @endif
            </span>
            <span class="user-name">
                @if (Session::get('admin_name'))
                    {{ Session::get('admin_name') }}
                @endif
            </span>
        </a>
        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
            <a class="dropdown-item" href="{{ asset('admin/view_profile/' . Session::get('admin_id')) }}">
                <i class="dw dw-user1"></i> Thông Tin Cá Nhân
            </a>
            <a class="dropdown-item" href="{{ URL::to('logout_admin') }}">
                <i class="dw dw-logout"></i> Đăng Xuất
            </a>
        </div>
    </div>
</div>
