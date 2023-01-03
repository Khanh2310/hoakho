@extends('admin.layout_admin')
@section('container')
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ URL::to('admin/') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Danh sách sản phẩm voucher</li>
                        </ol>
                    </nav>
                </div>

                <div class="col-md-6 col-sm-12">
                </div>
            </div>
        </div>

        <!-- Simple Datatable start -->
        <div class="card-box mb-30">
            <div class="row pd-20">
                <div class="col-10 pd-20">
                    <h4 class="text-blue h4">Danh Sách Sản Phẩm Voucher</h4>
                </div>
            </div>
            <div class="pb-20">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer ">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div id="DataTables_Table_0_filter" class="dataTables_filter">
                                <form action="">
                                    @csrf
                                    <label>Tìm Kiếm:<input type="search" class="form-control form-control-sm" id="find_product_voucher" placeholder="Tìm Kiếm" aria-controls="DataTables_Table_0"></label>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="content_find_product_voucher">
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="data-table table table-hover multiple-select-row nowrap no-footer dtr-inline sortable" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                        <tr role="row" class="text-center">
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">STT</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" data-defaultsign="AZ">Sản Phẩm</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Số Lượng Voucher
                                            </th>
                                            <th class="datatable-nosort sorting_disabled" rowspan="1" colspan="1" aria-label="Action" data-defaultsort="disabled">Thao Tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $stt = 0;
                                            $count_product_voucher = 0;
                                        @endphp
                                        @foreach ($all_product as $product)
                                            @php
                                                $unique_product_id = App\Http\Controllers\VoucherController::unique_product($product->product_id);
                                            @endphp
                                            @if ($unique_product_id == 1)
                                                @php
                                                    $stt++;
                                                    $count_product_voucher++;
                                                @endphp
                                                <tr role="row" class="odd text-center">
                                                    <td>{{ $stt }}</td>
                                                    <td>
                                                        <a href="{{ URL::to('admin/all_voucher/' . $product->product_id) }}">
                                                            {{ $product->product_name }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        @php
                                                            $count_voucher = 0;
                                                        @endphp
                                                        @foreach ($all_voucher as $voucher)
                                                            @if ($voucher->product_id == $product->product_id)
                                                                @php
                                                                    $count_voucher++;
                                                                @endphp
                                                            @endif
                                                        @endforeach
                                                        {{ $count_voucher }}
                                                    </td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                                <i class="dw dw-more"></i>
                                                            </a>

                                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                                <a class="dropdown-item" href="{{ URL::to('admin/all_voucher/' . $product->product_id) }}"><i class="dw dw-eye"></i>Xem danh sách
                                                                    voucher</a>
                                                                @hasrole(['admin', 'manager'])
                                                                    <a class="dropdown-item" href="{{ URL::to('admin/add_product_voucher/' . $product->product_id) }}"><i class="icon-copy dw dw-add"></i>Thêm voucher</a>
                                                                @endhasrole
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        @if ($count_product_voucher == 0)
                                            <tr>
                                                <td colspan="4" class="text-center">
                                                    Hiện không tồn tại sản phẩm nào có voucher
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-5">
                        </div>
                        <div class="col-sm-12 col-md-7">
                            @if ($count_product_voucher == 0)
                                <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                                    <ul class="pagination">
                                        {{-- {!! $all_product->links() !!} --}}
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('public/font_end/assets/js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('public/back_end/custom_voucher/search_product_voucher.js') }}"></script>
@endsection
