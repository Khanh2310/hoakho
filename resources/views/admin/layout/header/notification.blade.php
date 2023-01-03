@php
    $notification = App\Http\Controllers\DashboardController::NotificationsOrder();
@endphp
<div class="user-notification">
    <div class="dropdown">
        <a class="dropdown-toggle no-arrow" href="#" role="button" data-toggle="dropdown">
            <i class="icon-copy dw dw-notification"></i>
            @if (count($notification) > 0)
                <span class="badge notification-active"></span>
            @endif
        </a>
        <div class="dropdown-menu dropdown-menu-right">
            <div class="notification-list mx-h-350 customscroll">
                @if (count($notification) > 0)
                    <ul>
                        @foreach ($notification as $noti)
                            <li>
                                <a href="{{ URL::to('admin/detail_order_item/'.$noti->order_id) }}">
                                    <img src="{{ URL::to('public/upload/'.$noti->customer_avt) }}" alt="">
                                    <h3>{{ $noti->username }}</h3>
                                    <p>
                                        Có đơn hàng đang chờ duyệt từ {{ $noti->username }}
                                    </p>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="center">
                        Chưa có thông báo nào
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
