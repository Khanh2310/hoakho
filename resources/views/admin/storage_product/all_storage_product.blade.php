@extends('admin.layout_admin')
@section('container')
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-8 col-sm-12">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ URL::to('admin/') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item"><a href="{{ URL::to('admin/all_storage') }}">Danh sách kho hàng</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Danh sách kho sản phẩm</li>
                        </ol>
                    </nav>
                </div>

                <div class="col-md-6 col-sm-12">
                    {{-- <div class="dropdown">
                    <a class="btn btn-primary dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                        January 2018
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="#">Export List</a>
                        <a class="dropdown-item" href="#">Policies</a>
                        <a class="dropdown-item" href="#">View Assets</a>
                    </div>
                </div> --}}
                </div>
            </div>
        </div>

        <div class="card-box mb-30">
            @if (session('success_import_storage_product'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ session('success_import_storage_product') }}
                </div>
            @endif
        </div>

        <div class="card-box mb-30">
            @if (session('success_update_storage_product'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ session('success_update_storage_product') }}
                </div>
            @endif
        </div>

        <div class="card-box mb-30">
            @if (session('success_delete_soft_storage_product'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ session('success_delete_soft_storage_product') }}
                </div>
            @endif
        </div>

        <div class="card-box mb-30">
            @if (session('error_delete_soft_storage_product'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ session('error_delete_soft_storage_product') }}
                </div>
            @endif
        </div>

        <div class="card-box mb-30">
            @if (session('success_delete_storage_product'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ session('success_delete_storage_product') }}
                </div>
            @endif
        </div>

        <!-- Simple Datatable start -->
        <div class="card-box mb-30">
            <div class="content_filter_storage_product">
                <div class="row pd-20">
                    <div class="pd-20">
                        <h4 class="text-blue h4">Danh Sách Sản Phẩm {{ $storage_name }}</h4>
                    </div>
                </div>
                <div class="pb-20">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer ">
                        <div class="row">
                            <div class="col-sm-12 col-md-6 d-flex">
                                <div class="content_filter pl-20">
                                    <div class="dropdown">
                                        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                                            <i class="icon-copy dw dw-filter"></i> Lọc
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-left" style="">
                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#Modal_filter_storage_product_follow_quantity">Số lượng sản
                                                phẩm trong kho</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="content_print_pdf_storage_product ml-10">
                                    <form action="{{ URL::to('admin/print_pdf_storage_product') }}" method="post">
                                        @csrf
                                        {{-- type filter --}}
                                        <input type="hidden" class="type_filter" name="type_filter" value="">
                                        <input type="hidden" class="level_filter" name="level_filter" value="">
                                        <input type="hidden" name="quantity_start" value="">
                                        <input type="hidden" name="quantity_end" value="">
                                        <input type="hidden" name="storage_id" value="{{ $storage_id }}">
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
                                        <label>Tìm Kiếm:<input type="search" class="form-control form-control-sm" id="find_storage_product" placeholder="Tìm Kiếm"
                                                aria-controls="DataTables_Table_0"></label>
                                        <input type="hidden" value="{{ $storage_id }}" name="storage_id" id="storage_id">
                                    </form>
                                </div>
                            </div>
                        </div>
                        @if (count($all_storage_product) > 0)
                            <div class="content_find_storage_product">
                                <div class="row">
                                    <div class="col-12">
                                        <table class="data-table table table-hover multiple-select-row nowrap no-footer dtr-inline sortable" id="DataTables_Table_0" role="grid"
                                            aria-describedby="DataTables_Table_0_info">
                                            <thead>
                                                <tr role="row">
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">STT</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" data-defaultsort="disabled">Hình Ảnh</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" data-defaultsign="AZ">Tên Sản Phẩm</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Số lượng
                                                    </th>
                                                    <th class="datatable-nosort sorting_disabled" rowspan="1" colspan="1" aria-label="Action" data-defaultsort="disabled">Thao Tác</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $stt = 0;
                                                @endphp
                                                @foreach ($all_storage_product as $storage_product)
                                                    @php
                                                        $stt++;
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $stt }}</td>
                                                        @foreach ($all_product as $product)
                                                            @if ($storage_product->product_id == $product->product_id)
                                                                <td class="table-plus sorting_1" tabindex="0">
                                                                    <div class="da-card box-shadow" style="height: 80px; width: 80px">
                                                                        <div class="da-card-photo">
                                                                            <img src="{{ asset('public/upload/' . $product->product_image) }}" style="height: 80px !important; width: 80px !important;"
                                                                                alt="hình ảnh" srcset="">
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>{{ $product->product_name }}</td>
                                                            @endif
                                                        @endforeach
                                                        <td>{{ $storage_product->total_quantity_product }}</td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                                    <i class="dw dw-more"></i>
                                                                </a>
                                                                <div
                                                                    class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                                    @hasrole(['admin','manager'])
                                                                    <a class="dropdown-item"
                                                                        href="{{ URL::to('admin/import_storage_product/' . $storage_product->storage_product_id) }}"><i
                                                                            class="icon-copy dw dw-add"></i>Nhập hàng</a>
                                                                    @endhasrole
                                                                    <a class="dropdown-item"
                                                                        href="{{ URL::to('admin/history_storage_product/' . $storage_product->storage_product_id) }}"><i
                                                                            class="dw dw-eye"></i>Xem Lịch sử</a>
                                                                    @hasrole(['admin','manager'])
                                                                    <a class="dropdown-item"
                                                                        href="{{ URL::to('admin/update_storage_product/' . $storage_product->storage_product_id) }}"><i
                                                                            class="dw dw-edit2"></i>Chỉnh Sửa</a>
                                                                    @endhasrole
                                                                    @hasrole(['admin'])
                                                                    <button
                                                                        class="dropdown-item soft_delete_storage_product_class"
                                                                        data-id="{{ $storage_product->storage_product_id }}"
                                                                        data-toggle="modal" data-target="#Modal_delete"><i
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
                        @else
                            <div class="center">
                                Kho sản phẩm trống
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-sm-12 col-md-5">
                                @hasrole(['admin'])
                                <a href="{{ URL::to('admin/view_recycle_storage_product/' . $storage_id) }}"
                                    class="btn color-btn-them ml-10" style="color: white"><i
                                        class="dw dw-delete-3"></i>Thùng Rác</a>
                                @endhasrole
                            </div>
                            <div class="col-sm-12 col-md-7">
                                <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                                    <ul class="pagination">
                                        {!! $all_storage_product->links() !!}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- The Modal -->
        <div class="modal fade" id="Modal_delete">
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
                        <form action="{{ URL::to('admin/soft_delete_storage_product') }}" method="post" name="form_soft_delete">
                            @csrf
                            <input type="hidden" class="id_delete_storage_product" name="storage_product_id" value="">
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
        @include('admin.storage_product.modal_filter_storage_product')
        <script src="{{ asset('public/font_end/assets/js/jquery-3.4.1.min.js') }}"></script>
        <script src="{{ asset('public/back_end/filter_storage_product/filter_storage_product.js') }}"></script>
    </div>
@endsection
