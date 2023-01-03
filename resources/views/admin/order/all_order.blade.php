@extends('admin.layout_admin')
@section('container')
<div class="min-height-200px">

    <div class="page-header">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ URL::to('admin/') }}">Trang chủ</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Danh sách đơn hàng</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="title pb-20">
        <h2 class="h3 mb-0">Thống Kê Đơn Hàng</h2>
    </div>

    <div class="row pb-10">
        <div class="col-xl-4 col-lg-4 col-md-6 mb-20">
            <div class="card-box height-100-p widget-style3">
                <a href="{{ URL::to('admin/await_confirm_order') }}">
                    <div class="d-flex flex-wrap">
                        <div class="widget-data">
                            <div class="weight-700 font-24 text-dark">{{ count($wait_confirm) }}</div>
                            <div class="font-14 text-secondary weight-500">Chờ Xác Nhận</div>
                        </div>
                        <div class="widget-icon">
                            <div class="icon" data-color="#f68589">
                                <i class="icon-copy dw dw-wall-clock1"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 mb-20">
            <div class="card-box height-100-p widget-style3">
                <a href="{{ URL::to('admin/confirmed') }}">
                    <div class="d-flex flex-wrap">
                        <div class="widget-data">
                            <div class="weight-700 font-24 text-dark">{{ count($confirmed) }}</div>
                            <div class="font-14 text-secondary weight-500">Chờ Giao</div>
                        </div>
                        <div class="widget-icon">
                            {{-- <i class="icon-copy dw dw-down-chevron"></i> --}}
                            <div class="icon" data-color="#f27d81">
                                <i class="icon-copy dw dw-compass-1"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 mb-20">
            <div class="card-box height-100-p widget-style3">
                <a href="{{ URL::to('admin/delivering') }}">
                    <div class="d-flex flex-wrap">
                        <div class="widget-data">
                            <div class="weight-700 font-24 text-dark">{{ count($delivering) }}</div>
                            <div class="font-14 text-secondary weight-500">Đang Giao</div>
                        </div>
                        <div class="widget-icon">
                            <div class="icon" data-color="#f67b88">
                                <i class="icon-copy dw dw-delivery-truck-2"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 mb-20">
            <div class="card-box height-100-p widget-style3">
                <a href="{{ URL::to('admin/delivery_success') }}">
                    <div class="d-flex flex-wrap">
                        <div class="widget-data">
                            <div class="weight-700 font-24 text-dark">{{ count($delivery_success) }}</div>
                            <div class="font-14 text-secondary weight-500">Đã Giao</div>
                        </div>
                        <div class="widget-icon">
                            <div class="icon" data-color="#98ddf5">
                                <i class="icon-copy dw dw-delivery-truck-1"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 mb-20">
            <div class="card-box height-100-p widget-style3">
                <a href="{{ URL::to('admin/cancelled') }}">
                    <div class="d-flex flex-wrap">
                        <div class="widget-data">
                            <div class="weight-700 font-24 text-dark">{{ count($cancelled) }}</div>
                            <div class="font-14 text-secondary weight-500">Đã Hủy</div>
                        </div>
                        <div class="widget-icon">
                            <div class="icon" data-color="#fc9f9f">
                                <i class="icon-copy dw dw-cancel" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 mb-20">
            <div class="card-box height-100-p widget-style3">
                <a href="#">
                    <div class="d-flex flex-wrap">
                        <div class="widget-data">
                            <div class="weight-700 font-24 text-dark">{{ count($orders) }}</div>
                            <div class="font-14 text-secondary weight-500">Tổng Đơn Hàng</div>
                        </div>
                        <div class="widget-icon">
                            <div class="icon" data-color="#91f5e9">
                                <i class="icon-copy dw dw-inbox-1"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="card-box mb-30 content_filter_order">
        <div class="row pd-20">
            <div class="pd-20">
                <h4 class="text-blue h4">Danh Sách Đơn Hàng</h4>
            </div>
        </div>
        <div class="pb-20">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer ">
                <div class="row">
                    <div class="col-sm-12 col-md-6 d-flex">
                        <div class="content_filter pl-20">
                            <div class="dropdown">
                                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="icon-copy dw dw-filter"></i> Lọc
                                </a>
                                <div class="dropdown-menu dropdown-menu-left" style="">
                                    <a class="dropdown-item" href="#" data-toggle="modal"
                                        data-target="#Modal_filter_order_follow_price">Theo giá</a>
                                    <a class="dropdown-item" href="#" data-toggle="modal"
                                        data-target="#Modal_filter_order_follow_payment_status">
                                        Trạng thái thanh toán
                                    </a>
                                    <a class="dropdown-item" href="#" data-toggle="modal"
                                        data-target="#Modal_filter_order_follow_method_pay">
                                        Hình thức thanh toán
                                    </a>
                                    <a class="dropdown-item" href="#" data-toggle="modal"
                                        data-target="#Modal_filter_order_follow_date">
                                        Theo ngày
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="content_print_pdf_product ml-10">
                            <form action="{{ URL::to('admin/print_pdf_order') }}" method="post">
                                @csrf
                                {{-- type filter --}}
                                    <input type="hidden" class="type_filter" name="type_filter" value="">
                                    <input type="hidden" class="level_filter" name="level_filter" value="">
                                    <input type="hidden" name="level_array" value="">
                                    <input type="hidden" name="price_filter_start" value="">
                                    <input type="hidden" name="price_filter_end" value="">
                                {{--  --}}
                                <button type="submit" class="btn btn-secondary">
                                    Xuất
                                    <img src="{{ asset('public/upload/pdf1.svg') }}" style="height: 25px" alt="">
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div id="DataTables_Table_0_filter" class="dataTables_filter">
                            <form action="">
                                @csrf
                                <label>Tìm Kiếm:<input type="search" class="form-control form-control-sm"  placeholder="Tìm Kiếm"
                                    aria-controls="DataTables_Table_0" id="search_order"></label>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="content_find_order">
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="data-table table table-hover multiple-select-row nowrap no-footer dtr-inline sortable"
                                id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                                <thead>
                                    <tr role="row">
                                        <th  class="sorting text-center" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1">STT</th>
                                        <th  class="sorting text-center" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" data-defaultsort="disabled">Mã Đơn Hàng</th>
                                        <th  class="sorting" text-center tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1">Tổng Giá Đơn Hàng</th>
                                        <th  class="sorting" text-center tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" data-defaultsort="disabled">Phương Thức Thanh Toán</th>
                                        <th  class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" data-defaultsort="disabled">Tình Trạng Đơn Hàng</th>
                                        <th  class="datatable-nosort sorting_disabled" rowspan="1" colspan="1"
                                            aria-label="Action" data-defaultsort="disabled">Trạng Thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $stt = 1;
                                    @endphp
                                    @foreach ($orders as $order)
                                                <tr role="row" class="odd">
                                                    <td class="text-center">{{ $stt++ }}</td>
                                                    <td class="text-center">
                                                        <a href="{{ URL::to('admin/detail_order_item/'.$order->order_id) }}"><b>{{ $order->order_code }}</b></a>
                                                    </td>
                                                    <td class="">{{ number_format($order->total_price, 0, ',', '.') }}₫</td>
                                                    <td class="">
                                                        @foreach ($payment_method as $method_pay)
                                                            @if ($order->payment_id == $method_pay->payment_id)
                                                                {{ $method_pay->payment_name }}
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    <td class="text-center">
                                                        @if ($order->status_pay == 1)
                                                            <span class="badge badge-success" style="width: 107px">Đã Thanh Toán</span>
                                                        @else
                                                            <span class="badge badge-danger" style="width: 107px">Chưa Thanh Toán</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @foreach ($order_detail_status as $status_order_detail)
                                                                @if ($order->order_id == $status_order_detail->order_id)
                                                                    @foreach ($status_order as $status)
                                                                        @if ($status->status_id == $status_order_detail->status_id)
                                                                            @if ($status_order_detail->status_id == 1)
                                                                                <span class="badge badge-warning" style="width: 88.5px;">{{ $status->status_name }}</span>

                                                                            @elseif($status_order_detail->status_id == 2)
                                                                                <span class="badge badge-info" style="width: 88.5px;">{{ $status->status_name }}</span>

                                                                            @elseif($status_order_detail->status_id == 3)
                                                                                <span class="badge" style="background-color:rgb(0, 180, 137); color: white; width: 88.5px;">{{ $status->status_name }}</span>

                                                                            @elseif($status_order_detail->status_id == 4)
                                                                                <span class="badge badge-success" style="width: 88.5px;">{{ $status->status_name }}</span>

                                                                            @elseif($status_order_detail->status_id == 5)
                                                                                <span class="badge badge-danger" style="width: 88.5px;">{{ $status->status_name }}</span>
                                                                            @endif

                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                        @endforeach
                                                    </td>
                                                </tr>
                                    @endforeach


                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-5"><div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite"></div></div>
                        <div class="col-sm-12 col-md-7">
                            <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                                <ul class="pagination">
                                    {!! $orders->links() !!}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
{{-- include modal filter order --}}
@include('admin.order.modal_filter_order')
@endsection
