@extends('admin.layout_admin')
@section('container')
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ URL::to('admin/') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Danh mục sản phẩm</li>
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
            @if (session('success_category'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ session('success_category') }}
                </div>
            @endif
        </div>

        <div class="card-box mb-30">
            @if (session('error_category'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ session('error_category') }}
                </div>
            @endif
        </div>


        <!-- Simple Datatable start -->
        <div class="card-box mb-30">
            <div class="row pd-20">
                <div class="pd-20">
                    <h4 class="text-blue h4">Danh Mục Sản Phẩm</h4>
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
                                    <label>Tìm Kiếm:<input type="search" class="form-control form-control-sm" id="find_category" placeholder="Tìm Kiếm" aria-controls="DataTables_Table_0"></label>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="content_find_category">
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="data-table table table-hover multiple-select-row nowrap no-footer dtr-inline sortable" id="DataTables_Table_0" role="grid"
                                    aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                        <tr role="row">
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">STT</th>
                                            <th class="table-plus datatable-nosort sorting_asc" rowspan="1" colspan="1" aria-label="Name" data-defaultsort="disabled">Hình Ảnh</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" data-defaultsign="AZ">Tên Danh Mục</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Ngày Thêm</th>
                                            @hasrole(['admin', 'manager'])
                                                <th class="datatable-nosort sorting_disabled" rowspan="1" colspan="1" aria-label="Action" data-defaultsort="disabled">Thao Tác</th>
                                            @endhasrole
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $stt = 0;
                                        @endphp
                                        @foreach ($all_category as $cate)
                                            @php
                                                $stt++;
                                            @endphp
                                            <tr role="row" class="odd">
                                                <td>{{ $stt }}</td>
                                                <td class="table-plus sorting_1" tabindex="0">
                                                    <div class="da-card box-shadow" style="height: 80px; width: 80px">
                                                        <div class="da-card-photo">
                                                            <img src="{{ asset('public/upload/' . $cate->cate_image) }}" alt="hình ảnh" style="height: 80px !important; width: 80px !important;" srcset=""
                                                                width="80" height="80">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $cate->cate_name }}</td>
                                                <td>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $cate->created_at)->format('d-m-Y') }}
                                                </td>
                                                @hasrole(['admin','manager'])
                                                <td>
                                                    <div class="dropdown">
                                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                            <i class="dw dw-more"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                            @hasrole(['admin', 'manager'])
                                                                <a class="dropdown-item" href="{{ URL::to('admin/update_category/' . $cate->cate_id) }}"><i class="dw dw-edit2"></i>Chỉnh Sửa</a>
                                                            @endhasrole
                                                            @hasrole(['admin'])
                                                                <button class="dropdown-item soft_delete_category_class" data-id="{{ $cate->cate_id }}" data-toggle="modal" data-target="#Modal_delete"><i
                                                                        class="dw dw-delete-3"></i>Xóa</button>
                                                            @endhasrole
                                                        </div>
                                                    </div>
                                                </td>
                                                @endhasrole
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-5">
                            @hasrole(['admin'])
                                <a href="{{ URL::to('admin/view_recycle_cate') }}" class="btn color-btn-them ml-10" style="color: white"><i class="dw dw-delete-3"></i> Thùng Rác</a>
                            @endhasrole
                        </div>
                        <div class="col-sm-12 col-md-7">
                            <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                                <ul class="pagination">
                                    {!! $all_category->links() !!}
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
                        <form action="{{ URL::to('admin/soft_delete_cate') }}" method="post" name="form_soft_delete">
                            @csrf
                            <input type="hidden" class="id_delete_category" name="cate_id" value="">
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
    </div>
@endsection
