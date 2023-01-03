<div class="content content_top">
    <div class="content_top--left">
        <img src="{{ asset('public/upload/voucher_admin.png') }}" alt="voucher image" class="voucher_img">
    </div>
    <div class="content_top--right">
        <div class="content__voucher-top">
            <span class="voucher-label">Code:</span>
            <span class="voucher-text">{{ $voucher->voucher_code }}</span>
        </div>
        <div class="content__voucher-top">
            <span class="voucher-label">Tên voucher:</span>
            <span class="voucher-text">{{ $voucher->voucher_name }}</span>
        </div>
        <div class="content__voucher-top">
            <span class="voucher-label">Áp dụng cho sản phẩm:</span>
            <span class="voucher-text">{{ $product->product_name }}</span>
        </div>
        <div class="content__voucher-top">
            <span class="voucher-label">Ngày bắt đầu:</span>
            <span class="voucher-text">{{ $voucher->start_date }}</span>
        </div>
        <div class="content__voucher-top">
            <span class="voucher-label">Ngày kết thúc:</span>
            <span class="voucher-text">{{ $voucher->end_date }}</span>
        </div>
    </div>
</div>
<div class="content content_bottom">
    <div class="content__voucher-info">
        <div class="content__voucher-info--bottom">
            <span class="voucher-label">Số tiền được giảm:</span>
            <span class="voucher-text">{{ $voucher->voucher_amount }}</span>
        </div>
        <div class="content__voucher-info--bottom">
            <span class="voucher-label">Số lượng voucher:</span>
            <span class="voucher-text">{{ $voucher->voucher_quantity }}</span>
        </div>
        <div class="content__voucher-info--bottom">
            <span class="voucher-label">Trạng thái:</span>
            <span class="voucher-text">
                @php
                    $now = Carbon\Carbon::now();
                @endphp
                @if ($voucher->start_date <= $now && $now <= $voucher->end_date && $voucher->voucher_quantity > 0)
                    <span class="badge badge-success" style="width: 105px;">Đang áp dụng</span>
                @elseif ($voucher->start_date > $now)
                    <span class="badge badge-warning" style="width: 105px;">Chưa áp dụng</span>
                @else
                    <span class="badge badge-danger" style="width: 105px;">Ngưng áp dụng</span>
                @endif
            </span>
        </div>
    </div>
</div>
