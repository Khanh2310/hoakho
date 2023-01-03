@extends('admin.layout_admin')
@section('container')
    <link rel="stylesheet" href="{{ asset('public/back_end/custom_voucher/modal_voucher_css.css') }}">
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ URL::to('admin/') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item"><a href="{{ URL::to('admin/all_product_voucher') }}">Danh sách sản phẩm voucher</a></li>
                            <li class="breadcrumb-item"><a href="{{ URL::to('admin/all_voucher/' . $product->product_id) }}">Danh sách voucher</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Chi Tiết voucher</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                </div>
            </div>
        </div>
        <div class="pd-20 card-box mb-30">
            <div class="pd-20">
                <h4 class="text-blue h4">Chi Tiết Voucher</h4>
            </div>
            <div class="pd-20">
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
                            <span class="voucher-text">{{ date('d-m-Y H:i a', strtotime($voucher->start_date)) }}</span>
                        </div>
                        <div class="content__voucher-top">
                            <span class="voucher-label">Ngày kết thúc:</span>
                            <span class="voucher-text">{{ date('d-m-Y H:i a', strtotime($voucher->end_date)) }}</span>
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
            </div>
        </div>
    </div>
@endsection
