<div class="left-side-bar">
    <div class="brand-logo">
        <a href="{{ URL::to('/admin') }}">
            <img id="logo_left_side_admin" src="{{ asset('public/upload/logo-flower.svg') }}" alt="" style="height: 46px;">
        </a>
        <div class="close-sidebar" data-toggle="left-sidebar-close">
            <i class="ion-close-round"></i>
        </div>
    </div>
    <div class="menu-block customscroll">
        <div class="sidebar-menu">

            <ul id="accordion-menu">
                @hasrole(['admin', 'manager'])
                    <li class="dropdown">
                        <a href="javascript:;" class="dropdown-toggle">
                            <span class="micon dw dw-house-1"></span>
                            <span class="mtext">Quản Trị</span>
                        </a>
                        <ul class="submenu">
                            @hasrole(['admin', 'manager'])
                                <li><a href="{{ URL::to('admin/all_admin') }}">Danh Sách Quản Trị</a></li>
                            @endhasrole
                            @hasrole(['admin'])
                                <li><a href="{{ URL::to('admin/add_admin') }}">Thêm Quản Trị Viên</a></li>
                            @endhasrole
                            @hasrole(['admin', 'manager'])
                                <li><a href="{{ URL::to('admin/list_permission') }}">Phân Quyền</a></li>
                            @endhasrole
                        </ul>
                    </li>
                @endhasrole
                @hasrole(['admin', 'manager', 'employee'])
                    {{-- CUSTOMER --}}
                    <li class="dropdown">
                        <a href="javascript:;" class="dropdown-toggle">
                            <span class="micon dw dw-user2"></span>
                            <span class="mtext">Khách Hàng</span>
                        </a>
                        <ul class="submenu">
                            <li><a href="{{ URL::to('admin/all_customer') }}">Danh Sách Khách Hàng</a></li>
                        </ul>
                    </li>
                @endhasrole
                <li>
                    <div class="dropdown-divider"></div>
                </li>
                @hasrole(['admin', 'manager', 'employee'])
                    <li class="dropdown">
                        <a href="javascript:;" class="dropdown-toggle">
                            <span class="micon dw dw-inbox-4"></span>
                            <span class="mtext">Sản Phẩm</span>
                        </a>
                        <ul class="submenu">
                            <li><a href="{{ URL::to('admin/all_product') }}">Danh Sách Sản Phẩm</a></li>
                            @hasrole(['admin', 'manager'])
                                <li><a href="{{ URL::to('admin/add_product') }}">Thêm Sản Phẩm</a></li>
                            @endhasrole
                        </ul>
                    </li>
                @endhasrole
                {{-- CATEGORY --}}
                @hasrole(['admin', 'manager', 'employee'])
                    <li class="dropdown">
                        <a href="javascript:;" class="dropdown-toggle">
                            <span class="micon dw dw-list3"></span>
                            <span class="mtext">Danh Mục</span>
                        </a>
                        <ul class="submenu">
                            <li><a href="{{ URL::to('admin/all_category') }}">Danh Sách Danh Mục</a></li>
                            @hasrole(['admin', 'manager'])
                                <li><a href="{{ URL::to('admin/add_category') }}">Thêm Danh Mục</a></li>
                            @endhasrole
                        </ul>
                    </li>
                @endhasrole
                {{-- STORAGE --}}
                @hasrole(['admin', 'manager', 'employee'])
                    <li class="dropdown">
                        <a href="javascript:;" class="dropdown-toggle">
                            <span class="micon dw dw-wallet"></span>
                            <span class="mtext">Kho Hàng</span>
                        </a>
                        <ul class="submenu">
                            <li><a href="{{ URL::to('admin/all_storage') }}">Danh Sách Kho Hàng</a></li>
                        </ul>
                    </li>
                @endhasrole
                {{-- SHIPPING CODE --}}
                @hasrole(['admin', 'manager', 'employee'])
                    <li class="dropdown">
                        <a href="javascript:;" class="dropdown-toggle">
                            <span class="micon dw dw-money"></span>
                            <span class="mtext">Phí Vận Chuyển</span>
                        </a>
                        <ul class="submenu">
                            <li><a href="{{ URL::to('admin/all_shipping_cost') }}">Danh Sách Phí</a></li>
                            @hasrole(['admin', 'manager'])
                                <li><a href="{{ URL::to('admin/add_shipping_cost') }}">Thêm Phí Vận Chuyển</a></li>
                            @endhasrole
                        </ul>
                    </li>
                @endhasrole
                <li>
                    <div class="dropdown-divider"></div>
                </li>


                {{-- ACCEP --}}
                <li>
                    <div class="sidebar-small-cap" style="color: #334148;">Xét Duyệt</div>
                </li>
                {{-- ORDER --}}
                @hasrole(['admin', 'manager', 'employee'])
                    <li class="dropdown">
                        <a href="javascript:;" class="dropdown-toggle">
                            <span class="micon dw dw-file"></span>
                            <span class="mtext">Đơn Hàng</span>
                        </a>
                        <ul class="submenu">
                            <li><a href="{{ URL::to('admin/all_order') }}">Danh Sách Đơn Hàng</a></li>
                        </ul>
                    </li>
                @endhasrole
                {{-- COMMENT --}}
                @hasrole(['admin', 'manager', 'employee'])
                    <li class="dropdown">
                        <a href="javascript:;" class="dropdown-toggle">
                            <span class="micon dw dw-chat-4"></span>
                            <span class="mtext">Duyệt Bình Luận</span>
                        </a>
                        <ul class="submenu">
                            <li><a href="{{ URL::to('admin/view_comment_to_process') }}">Bình luận chờ duyệt</a></li>
                        </ul>
                    </li>
                @endhasrole
                <li>
                    <div class="dropdown-divider"></div>
                </li>

                {{-- EVENT DISCOUNT --}}
                @hasrole(['admin', 'manager', 'employee'])
                    <li>
                        <div class="sidebar-small-cap" style="color: #334148;">Sự Kiện</div>
                    </li>
                    {{-- DISCOUNT --}}
                    <li class="dropdown">
                        <a href="javascript:;" class="dropdown-toggle">
                            <span class="micon dw dw-analytics-111"></span>
                            <span class="mtext">Giảm Giá</span>
                        </a>
                        <ul class="submenu">
                            <li><a href="{{ URL::to('admin/all_discount') }}">Danh Sách Giảm Giá</a></li>
                            @hasrole(['admin', 'manager'])
                                <li><a href="{{ URL::to('admin/add_discount') }}">Thêm Giảm Giá</a></li>
                            @endhasrole
                        </ul>
                    </li>
                @endhasrole
                {{-- VOUCHER --}}
                @hasrole(['admin', 'manager', 'employee'])
                    <li class="dropdown">
                        <a href="javascript:;" class="dropdown-toggle">
                            <span class="micon dw dw-ticket-1"></span>
                            <span class="mtext">Voucher</span>
                        </a>
                        <ul class="submenu">
                            <li><a href="{{ URL::to('admin/all_product_voucher') }}">DS Sản Phẩm Voucher</a></li>
                            @hasrole(['admin', 'manager'])
                                <li><a href="{{ URL::to('admin/add_voucher') }}">Thêm Voucher</a></li>
                            @endhasrole
                        </ul>
                    </li>
                @endhasrole

                <li>
                    <div class="dropdown-divider"></div>
                </li>
                {{-- FONT-END --}}
                @hasrole(['admin'])
                    <li>
                        <div class="sidebar-small-cap" style="color: #334148;">Giao Diện</div>
                    </li>
                    {{-- SLIDER --}}
                    <li class="dropdown">
                        <a href="javascript:;" class="dropdown-toggle">
                            <span class="micon dw dw-slideshow"></span>
                            <span class="mtext">Slider</span>
                        </a>
                        <ul class="submenu">
                            <li><a href="{{ URL::to('admin/all_slider') }}">Danh sách slider</a></li>
                            <li><a href="{{ URL::to('admin/add_slider') }}">Thêm slider</a></li>
                        </ul>
                    </li>
                @endhasrole
            </ul>
        </div>
    </div>
</div>
