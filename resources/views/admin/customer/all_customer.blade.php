@extends('admin.layout_admin')
@section('container')
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ URL::to('admin/') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Danh sách khách hàng</li>
                        </ol>
                    </nav>
                </div>

                <div class="col-md-6 col-sm-12">

                </div>
            </div>
        </div>

        <div class="card-box mb-30">
            @if (session('success_delete_storage'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ session('success_delete_storage') }}
                </div>
            @endif
        </div>

        <div class="card-box mb-30">
            @if (session('check_delete_storage'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ session('check_delete_storage') }}
                </div>
            @endif
        </div>

        <!-- Simple Datatable start -->
        <div class="card-box mb-30 content_filter_customer">
            <div class="pd-20">
                <h4 class="text-blue h4">Danh Sách Khách Hàng</h4>
            </div>
            <div class="pb-20 ">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer ">
                    <div class="row">
                        <div class="col-sm-12 col-md-6 d-flex">
                            <div class="content_filter pl-20">
                                <div class="dropdown">
                                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                                        <i class="icon-copy dw dw-filter"></i> Lọc
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-left" style="">
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#Modal_filter_customer_follow_order_quantity">Số lượng đơn đặt
                                            hàng</a>
                                    </div>
                                </div>
                            </div>
                            <div class="content_print_pdf_customer ml-10">
                                <form action="{{ URL::to('admin/print_pdf_customer') }}" method="post">
                                    @csrf
                                    {{-- type filter --}}
                                    <input type="hidden" class="type_filter" name="type_filter" value="">
                                    <input type="hidden" class="level_filter" name="level_filter" value="">
                                    <input type="hidden" name="quantity_start" value="">
                                    <input type="hidden" name="quantity_end" value="">
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
                                    <label>Tìm Kiếm:<input type="search" class="form-control form-control-sm" id="find_customer" placeholder="Tìm Kiếm" aria-controls="DataTables_Table_0"></label>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="content_find_customer">
                        @if (count($all_customer) > 0)
                            {{-- <input type="hidden" class="customer_id" name="customer_id"
                                value="{{ $customer->customer_id }}"> --}}
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <div class="row">
                                <div class="col-12 table-responsive">
                                    <table class="data-table table table-hover multiple-select-row nowrap no-footer dtr-inline sortable" id="DataTables_Table_0" role="grid"
                                        aria-describedby="DataTables_Table_0_info">
                                        <thead>
                                            <tr role="row">
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">STT
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" data-defaultsign="AZ">Họ Và Tên</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Số Điện
                                                    Thoại</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" data-defaultsign="AZ">Email</th>
                                                <th class="sorting text-center" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">
                                                    Đơn Hàng Đã
                                                    Mua</th>
                                                <th class="datatable-nosort sorting_disabled text-center" rowspan="1" colspan="1" aria-label="Action" data-defaultsort="disabled">Thao Tác
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $stt = 0;
                                            @endphp
                                            @foreach ($all_customer as $customer)
                                                @php
                                                    $stt++;
                                                @endphp
                                                <tr role="row" class="odd">
                                                    <td>{{ $stt }}</td>
                                                    <td>
                                                        <a href="{{ URL::to('admin/detail_customer/' . $customer->customer_id) }}">
                                                            <div class="name-avatar d-flex align-items-center">
                                                                <div class="avatar mr-2 flex-shrink-0">

                                                                    <img src="{{ asset('public/upload/' . $customer->customer_avt) }}" class="border-radius-100 shadow" style="width: 50px; height: 50px"
                                                                        alt="avt admin">
                                                                </div>
                                                                <div class="txt">
                                                                    <div class="weight-600">{{ $customer->username }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </td>
                                                    @if ($customer->customer_phone != '')
                                                        <td>{{ $customer->customer_phone }}</td>
                                                    @else
                                                        <td>Chưa cập nhật</td>
                                                    @endif
                                                    <td>{{ $customer->email }}</td>
                                                    <td class="text-center">
                                                        @php
                                                            $count_order = 0;
                                                        @endphp
                                                        @foreach ($all_order as $order)
                                                            @if ($order->customer_id == $customer->customer_id)
                                                                @php
                                                                    $count_order++;
                                                                @endphp
                                                            @endif
                                                        @endforeach
                                                        {{ $count_order }}
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="{{ URL::to('admin/detail_customer/' . $customer->customer_id) }}"><i class="dw dw-eye"></i> Xem chi tiết</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @else
                            <div class="center">Hiện không có khách hàng nào!</div>
                        @endif
                        <div class="row">
                            <div class="col-sm-12 col-md-5">
                            </div>
                            <div class="col-sm-12 col-md-7">
                                <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                                    <ul class="pagination">
                                        {!! $all_customer->links() !!}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.customer.modal_filter_order_customer')
    <script src="{{ asset('public/font_end/assets/js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('public/back_end/custom_customer_admin/custom_js.js') }}"></script>
    <script src="{{ asset('public/back_end/filter_customer/filter_order_customer.js') }}"></script>
@endsection
