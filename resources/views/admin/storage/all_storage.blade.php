@extends('admin.layout_admin')
@section('container')
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ URL::to('admin/') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Danh sách kho hàng</li>
                        </ol>
                    </nav>
                </div>

                <div class="col-md-6 col-sm-12">
                </div>
            </div>
        </div>

        <div class="card-box mb-30">
            @if (session('success_add_storage'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ session('success_add_storage') }}
                </div>
            @endif
        </div>

        <div class="card-box mb-30">
            @if (session('success_update_storage'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ session('success_update_storage') }}
                </div>
            @endif
        </div>

        <div class="card-box mb-30">
            @if (session('success_delete_soft_storage'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ session('success_delete_soft_storage') }}
                </div>
            @endif
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

        <div class="card-box mb-30">
            @if (session('check_storage_name'))
                <div class="alert alert-danger alert-dismissible mt-1">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ session('check_storage_name') }}
                </div>
            @endif
        </div>

        <div class="card-box-mb-30">
            @if ($errors->has('storage_name'))
                <div class="alert alert-danger alert-dismissible mt-1">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ $errors->first('storage_name') }}
                </div>
            @endif
        </div>

        <!-- Simple Datatable start -->
        <div class="card-box mb-30">
            <div class="row pd-20">
                <div class="col-10 pd-20">
                    <h4 class="text-blue h4">Danh Sách Kho Hàng</h4>
                </div>
                @hasrole(['admin', 'manager'])
                    <div class="col-2 mt-4">
                        <button class="btn color-btn-them add_storage float-right" data-id data-toggle="modal" data-target="#Modal_add_storage">Thêm kho</button>
                    </div>
                @endhasrole
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
                                    <label>Tìm Kiếm:<input type="search" class="form-control form-control-sm" id="find_storage" placeholder="Tìm Kiếm" aria-controls="DataTables_Table_0"></label>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="content_find_storage">
                        <table class="data-table table table-hover multiple-select-row nowrap no-footer dtr-inline sortable" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                            <thead>
                                <tr role="row">
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">STT</th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" data-defaultsign="AZ">Tên Loại</th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Ngày Thêm</th>
                                    <th class="datatable-nosort sorting_disabled" rowspan="1" colspan="1" aria-label="Action" data-defaultsort="disabled">Thao Tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $stt = 0;
                                @endphp
                                @foreach ($all_storage as $storage)
                                    @php
                                        $stt++;
                                    @endphp

                                    <tr role="row" class="odd">
                                        <td>{{ $stt }}</td>
                                        <td>
                                            <a href="{{ URL::to('admin/all_storage_product/' . $storage->storage_id) }}">
                                                {{ $storage->storage_name }}
                                            </a>
                                        </td>
                                        <td>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $storage->created_at)->format('d-m-Y') }}
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                    <i class="dw dw-more"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                    <a class="dropdown-item" href="{{ URL::to('admin/all_storage_product/' . $storage->storage_id) }}"><i class="dw dw-eye"></i>Xem kho hàng</a>

                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                    @hasrole(['admin', 'manager'])
                                                        <button class="dropdown-item update_storage" data-id={{ $storage->storage_id }} data-toggle="modal" data-target="#Modal_update_storage"><i class="dw dw-edit2"></i>Chỉnh Sửa</button>
                                                    @endhasrole
                                                    @hasrole(['admin'])
                                                        <button class="dropdown-item soft_delete_storage_class" data-id="{{ $storage->storage_id }}" data-toggle="modal" data-target="#Modal_delete"><i class="dw dw-delete-3"></i>Xóa</button>
                                                    @endhasrole
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-5">
                            @hasrole(['admin'])
                                <a href="{{ URL::to('admin/view_recycle_storage') }}" class="btn color-btn-them ml-10" style="color: white"><i class="dw dw-delete-3"></i> Thùng Rác</a>
                            @endhasrole
                        </div>
                        <div class="col-sm-12 col-md-7">
                            <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                                <ul class="pagination">
                                    {!! $all_storage->links() !!}
                                </ul>
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
                        <form action="{{ URL::to('admin/soft_delete_storage') }}" method="post" name="form_soft_delete">
                            @csrf
                            <input type="hidden" class="id_delete_storage" name="storage_id" value="">
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
        <!-- The Modal -->
        <div class="modal fade" id="Modal_add_storage">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Thêm Kho Hàng</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <form action="{{ URL::to('admin/process_add_storage') }}" method="post" name="add_storage">
                            @csrf
                            <label>Tên Kho Hàng</label>
                            <input class="form-control upper_val format_name_input" type="text" name="storage_name" value="{{ old('storage_name') }}" onblur="return upberFirstKey()" placeholder="Nhập Tên Kho Hàng">
                        </form>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button class="btn color-btn-them btn_add_storage">Thêm</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- The Modal -->
        <div class="modal fade" id="Modal_update_storage">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Sửa Kho Hàng</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <form action="{{ URL::to('admin/process_update_storage') }}" method="post" name="update_storage">
                            @csrf
                            <label>Tên Kho hàng</label>
                            <input type="hidden" class="form-control val_storage" name="storage_id" value="">
                            <input class="form-control upper_val name_storage_update" type="text" name="storage_name" onblur="return upberFirstKey()">
                        </form>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button class="btn color-btn-them btn_update_storage">Sửa</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
