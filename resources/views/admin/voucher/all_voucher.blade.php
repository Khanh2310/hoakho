@extends('admin.layout_admin')
@section('container')
    <link rel="stylesheet" href="{{ asset('public/back_end/custom_voucher/modal_voucher_css.css') }}">
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-8 col-sm-12">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ URL::to('admin/') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item"><a href="{{ URL::to('admin/all_product_voucher') }}">Danh sách sản
                                    phẩm voucher</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Danh sách Voucher</li>
                        </ol>
                    </nav>
                </div>

                <div class="col-md-6 col-sm-12">

                </div>
            </div>
        </div>

        <div class="card-box mb-30">
            @if (session('add_voucher_success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ session('add_voucher_success') }}
                </div>
            @endif
        </div>

        <div class="card-box mb-30">
            @if (session('update_voucher_success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ session('update_voucher_success') }}
                </div>
            @endif
        </div>

        <div class="card-box mb-30">
            @if (session('error_delete_soft_voucher'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ session('error_delete_soft_voucher') }}
                </div>
            @endif
        </div>

        <div class="card-box mb-30">
            @if (session('success_delete_soft_voucher'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ session('success_delete_soft_voucher') }}
                </div>
            @endif
        </div>

        <!-- Simple Datatable start -->
        <div class="card-box mb-30">
            <div class="content_filter_voucher">
                <div class="row pd-20">
                    <div class="col-10 pd-20">
                        <h4 class="text-blue h4">Danh Sách Voucher - {{ $product_name }}</h4>
                    </div>
                </div>
                <div class="pb-20">
                    @if (count($all_voucher) > 0)
                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer ">
                            <div class="row">
                                <div class="col-sm-12 col-md-6 d-flex">
                                    <div class="content_filter pl-20">
                                        <div class="dropdown">
                                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                                                <i class="icon-copy dw dw-filter"></i> Lọc
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-left" style="">
                                                <a class="dropdown-item btn_filter_voucher_follow_status_apply" href="#">Đang áp dụng
                                                </a>
                                                <a class="dropdown-item btn_filter_voucher_follow_status_unapply" href="#">Ngưng áp dụng
                                                </a>
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#Modal_filter_voucher_follow_date_create">
                                                    Ngày tạo voucher
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="content_print_pdf_voucher ml-10">
                                        <form action="{{ URL::to('admin/print_pdf_voucher') }}" method="post">
                                            @csrf
                                            {{-- type filter --}}
                                            <input type="hidden" class="type_filter" name="type_filter" value="">
                                            <input type="hidden" class="level_filter" name="level_filter" value="">
                                            <input type="hidden" name="date_start" value="">
                                            <input type="hidden" name="date_end" value="">
                                            <input type="hidden" name="product_id" value="{{ $product_id }}">
                                            {{--  --}}
                                            <button type="submit" class="btn btn-secondary">
                                                Xuất
                                                <img src="{{ asset('public/upload/pdf1.svg') }}" style="height: 25px" alt="">
                                            </button>
                                        </form>
                                    </div>
                                    @hasrole('admin')
                                        <div class="trace_voucher pl-10">
                                            <div class="dropdown">
                                                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                                                    <i class="icon-copy dw dw-search2"></i>
                                                    Truy vết theo
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-left" style="">
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#Modal_trace_voucher_side_voucher">
                                                        Voucher
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endhasrole
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div id="DataTables_Table_0_filter" class="dataTables_filter">
                                        <form action="">
                                            @csrf
                                            <input type="hidden" value="{{ $product_id }}" id="product_id">
                                            <label>Tìm Kiếm:<input type="search" class="form-control form-control-sm" placeholder="Tìm Kiếm" aria-controls="DataTables_Table_0" id="find_voucher"></label>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="content_find_voucher content_trace_voucher">
                                <div class="row">
                                    <div class="col-12 table-responsive">
                                        <table class="data-table table table-hover multiple-select-row nowrap no-footer dtr-inline sortable" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                                            <thead>
                                                <tr role="row" class="text-center">
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">STT</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" data-defaultsort="disabled">Mã Voucher</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" data-defaultsign="AZ">Tên Voucher</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Ngày Bắt
                                                        Đầu</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Ngày Kết
                                                        Thúc</th>
                                                    <th class="datatable-nosort sorting_disabled" rowspan="1" colspan="1" aria-label="Action" data-defaultsort="disabled">Tình Trạng</th>
                                                    <th class="datatable-nosort sorting_disabled" rowspan="1" colspan="1" aria-label="Action" data-defaultsort="disabled">Thao Tác</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $stt = 0;
                                                @endphp
                                                @foreach ($all_voucher as $voucher)
                                                    @php
                                                        $stt++;
                                                    @endphp
                                                    <tr role="row" class="odd text-center">
                                                        <td>{{ $stt }}</td>
                                                        <td style="cursor: pointer;">
                                                            <a href="#" class=" btn_open_modal" data-id={{ $voucher->voucher_id }} data-toggle="modal" data-target="#modal_voucher">
                                                                {{ $voucher->voucher_code }}
                                                            </a>
                                                        </td>
                                                        <td class="text-left" id="voucher_name" style="cursor: pointer;">
                                                            <a href="#" class=" btn_open_modal" data-id={{ $voucher->voucher_id }} data-toggle="modal" data-target="#modal_voucher">
                                                                {{ $voucher->voucher_name }}
                                                            </a>
                                                        </td>
                                                        <td>
                                                            {{ date('d-m-y H:i a', strtotime($voucher->start_date)) }}
                                                        </td>
                                                        <td>
                                                            {{ date('d-m-y H:i a', strtotime($voucher->end_date)) }}
                                                        </td>
                                                        <td>
                                                            @php
                                                                $now = Carbon\Carbon::now();
                                                            @endphp
                                                            @if ($voucher->start_date <= $now && $now <= $voucher->end_date && $voucher->voucher_quantity > 0)
                                                                <span class="badge badge-success" style="width: 105px;">Đang
                                                                    áp
                                                                    dụng</span>
                                                            @elseif ($voucher->start_date > $now)
                                                                <span class="badge badge-warning" style="width: 105px;">Chưa
                                                                    áp
                                                                    dụng</span>
                                                            @else
                                                                <span class="badge badge-danger" style="width: 105px;">Ngưng
                                                                    áp
                                                                    dụng</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                                    <i class="dw dw-more"></i>
                                                                </a>

                                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                                    <a class="dropdown-item" href="{{ URL::to('admin/detail_voucher/' . $voucher->voucher_id) }}"><i class="dw dw-eye"></i>Xem chi
                                                                        tiết</a>
                                                                    @hasrole(['admin', 'manager'])
                                                                        <a class="dropdown-item" href="{{ URL::to('admin/update_voucher/' . $voucher->voucher_id) }}"><i class="dw dw-edit2"></i>Chỉnh
                                                                            Sửa</a>
                                                                    @endhasrole
                                                                    @hasrole('admin')
                                                                        <button class="dropdown-item soft_delete_voucher" data-id="{{ $voucher->voucher_id }}" data-toggle="modal" data-target="#Modal_delete_voucher"><i
                                                                                class="dw dw-delete-3"></i>Xóa</button>
                                                                    @endhasrole
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="center">Hiện sản phẩm chưa có voucher</div>
                    @endif
                    <div class="row">
                        <div class="col-sm-12 col-md-5">
                            @hasrole('admin')
                                <a href="{{ URL::to('admin/view_recycle_product_voucher/' . $product_id) }}" class="btn color-btn-them ml-10" style="color: white"><i class="dw dw-delete-3"></i>
                                    Thùng Rác</a>
                            @endhasrole
                        </div>
                        <div class="col-sm-12 col-md-7">
                            <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                                <ul class="pagination">
                                    {!! $all_voucher->links() !!}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_voucher">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 900px;">
            <div class="modal-content" style="height: 550px;">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Chi Tiết Voucher</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="content_detail_voucher_ajax">

                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                </div>
            </div>
        </div>
    </div>
    <!-- The Modal -->
    <div class="modal fade" id="Modal_delete_voucher">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Thông Báo</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    Bạn có muốn xóa dữ liệu này ?
                    <form action="{{ URL::to('admin/soft_delete_voucher') }}" method="post" name="form_soft_delete">
                        @csrf
                        <input type="hidden" class="id_delete_voucher" name="voucher_id" value="">
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button class="btn btn-danger btn_delete_soft">Xóa</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{-- include modal filter voucher --}}
    @include('admin.voucher.modal_filter_voucher')
    {{-- include modal trace --}}
    @include('admin.voucher.modal_trace_voucher')
    <script src="{{ asset('public/font_end/assets/js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('public/back_end/custom_voucher/custom_voucher.js') }}"></script>
    <script src="{{ asset('public/back_end/filter_voucher/filter_voucher.js') }}"></script>
    {{-- <script src="{{ asset('public/back_end/custom_voucher/modal_voucher.js') }}"></script> --}}
    {{-- <script src="{{ asset('public/back_end/custom_voucher/search_voucher.js') }}"></script> --}}
    {{-- <script src="{{ asset('public/back_end/custom_voucher/delete_voucher.js') }}"></script> --}}
@endsection
