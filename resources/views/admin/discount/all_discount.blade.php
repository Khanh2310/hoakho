@extends('admin.layout_admin')
@section('container')
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ URL::to('admin/') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Danh sách giảm giá</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">

                </div>
            </div>
        </div>
        {{-- Message --}}
        @if (session('add_discount_success'))
            <div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session('add_discount_success') }}
            </div>
        @endif
        @if (session('delete_discount_success'))
            <div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session('delete_discount_success') }}
            </div>
        @endif
        <!-- Simple Datatable start -->
        <div class="content_filter_discount">
            <div class="card-box mb-30">
                <div class="pd-20">
                    <h4 class="text-blue h4">Danh Sách Giảm Giá Sản Phẩm</h4>
                </div>
                <div class="pb-20">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer ">
                        <div class="row">
                            <div class="col-sm-12 col-md-6 d-flex">
                                <div class="content_filter pl-20">
                                    <div class="dropdown">
                                        <a class="btn btn-secondary dropdown-toggle" href="#" role="button"
                                            data-toggle="dropdown" aria-expanded="false">
                                            <i class="icon-copy dw dw-filter"></i> Lọc
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-left" style="">
                                            <a class="dropdown-item" href="#" data-toggle="modal"
                                                data-target="#Modal_filter_discount_over_time">
                                                Thời hạn giảm giá
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="content_print_pdf_product ml-10">
                                    <form action="{{ URL::to('admin/print_pdf_discount') }}" method="post">
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
                                        <label>Tìm Kiếm:<input type="search" class="form-control form-control-sm"
                                                id="search_all_discount" placeholder="Tìm Kiếm"
                                                aria-controls="DataTables_Table_0"></label>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="content_find_admin">
                            <div class="row">
                                <div class="col-12 table-responsive">
                                    <table
                                        class="data-table table table-hover multiple-select-row nowrap no-footer dtr-inline sortable"
                                        id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                                        <thead>
                                            <tr role="row">
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1">STT</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1" data-defaultsign="AZ">Các Sản Phẩm</th>
                                                <th class="sorting text-center" tabindex="0"
                                                    aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Giảm Giá 1
                                                </th>
                                                <th class="sorting text-center" tabindex="0"
                                                    aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Giảm Giá 2
                                                </th>
                                                <th class="datatable-nosort sorting_disabled" rowspan="1" colspan="1"
                                                    aria-label="Action" data-defaultsort="disabled">Thao Tác</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table_all_discount">
                                            @php
                                                $stt = 0;
                                            @endphp
                                            @foreach ($all_discount as $discount)
                                                @php
                                                    $stt++;
                                                    $now = Carbon\Carbon::now();
                                                @endphp
                                                <tr role="row" class="odd">
                                                    <td>{{ $stt }}</td>
                                                    <td>
                                                        @foreach ($all_product as $product)
                                                            @if ($product->discount_id == $discount->discount_id)
                                                                <i class="icon-copy fa fa-check-circle" aria-hidden="true"
                                                                    style="color: #626364"></i>
                                                                {{ $product->product_name }}<br>
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    <td class="text-center">
                                                        @if ($discount->condition_discount_1 != '')
                                                            @if ($now > $discount->end_date_1)
                                                                @if ($discount->condition_discount_1 == 1)
                                                                    <del>-{{ $discount->amount_discount_1 }}%</del>
                                                                @else
                                                                    <del>-{{ number_format($discount->amount_discount_1, 0, ',', '.') }}vnđ</del>
                                                                @endif
                                                            @else
                                                                @if ($discount->condition_discount_1 == 1)
                                                                    -{{ $discount->amount_discount_1 }}%
                                                                @else
                                                                    -{{ number_format($discount->amount_discount_1, 0, ',', '.') }}vnđ
                                                                @endif
                                                            @endif
                                                        @else

                                                        @endif

                                                    </td>
                                                    <td class="text-center">
                                                        @if ($discount->condition_discount_2 != '')
                                                            @if ($now > $discount->end_date_2)
                                                                @if ($discount->condition_discount_2 == 1)
                                                                    <del>-{{ $discount->amount_discount_2 }}%</del>
                                                                @else
                                                                    <del>-{{ number_format($discount->amount_discount_2, 0, ',', '.') }}vnđ</del>
                                                                @endif
                                                            @else
                                                                @if ($discount->condition_discount_2 == 1)
                                                                    -{{ $discount->amount_discount_2 }}%
                                                                @else
                                                                    -{{ number_format($discount->amount_discount_2, 0, ',', '.') }}vnđ
                                                                @endif
                                                            @endif
                                                        @else

                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle"
                                                                href="#" role="button" data-toggle="dropdown">
                                                                <i class="dw dw-more"></i>
                                                            </a>
                                                            <div
                                                                class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                                <a class="dropdown-item"
                                                                    href="{{ URL::to('admin/detail_discount/' . $discount->discount_id) }}">
                                                                    <i class="dw dw-eye"></i>Chi tiết giảm giá
                                                                </a>
                                                                @hasrole(['admin', 'manager'])
                                                                    <a class="dropdown-item"
                                                                        href="{{ URL::to('admin/update_discount/' . $discount->discount_id) }}">
                                                                        <i class="dw dw-edit2"></i>Thiết lập lại
                                                                    </a>
                                                                @endhasrole
                                                                @hasrole('admin')
                                                                    <button class="dropdown-item btn_show_modal_delete_discount"
                                                                        data-id="{{ $discount->discount_id }}"
                                                                        data-toggle="modal"
                                                                        data-target="#Modal_delete_discount"><i
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
                            {{-- <div class="row">
                                <div class="col-sm-12 col-md-5">
                                    <a href="{{ URL::to('admin/view_recycle') }}" class="btn color-btn-them ml-10"
                                        style="color: white"><i class="dw dw-delete-3"></i> Thùng Rác</a>
                                </div>
                                <div class="col-sm-12 col-md-7">
                                    <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                                        <ul class="pagination">
                                            {!! $all_admin->links() !!}
                                        </ul>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- The Modal -->
        <div class="modal fade" id="Modal_delete_discount">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Thông Báo</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        Bạn có muốn xóa giảm giá này ?
                        <form action="{{ URL::to('admin/delete_discount') }}" method="post" name="form_delete_discount">
                            @csrf
                            <input type="hidden" class="id_delete_discount" name="discount_id" value="">
                        </form>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button class="btn btn-danger btn_confirm_delete_discount">Xóa</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                    </div>
                </div>
            </div>
        </div>
        @include('admin.discount.modal_filter_discount')
    @endsection
