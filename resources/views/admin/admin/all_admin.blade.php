@extends('admin.layout_admin')
@section('container')
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ URL::to('admin/') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Danh sách quản trị viên</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                </div>
            </div>
        </div>
        {{-- Message --}}
        @if (session('delete_success'))
            <div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session('delete_success') }}
            </div>
        @endif
        @if (session('add_admin_success'))
            <div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session('add_admin_success') }}
            </div>
        @endif
        @if (session('update_success_admin'))
            <div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session('update_success_admin') }}
            </div>
        @endif

        <!-- Simple Datatable start -->
        <div class="card-box mb-30 content_filter_admin">
            <div class="pd-20">
                <h4 class="text-blue h4">Danh Sách Quản Trị Viên</h4>
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
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#Modal_filter_admin_roles">
                                            Chức vụ
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="content_print_pdf_product ml-10">
                                <form action="{{ URL::to('admin/print_pdf_admin') }}" method="post">
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
                                    <label>Tìm Kiếm:<input type="search" class="form-control form-control-sm" id="find_admin" placeholder="Tìm Kiếm" aria-controls="DataTables_Table_0"></label>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="content_find_admin">
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="data-table table table-hover multiple-select-row nowrap no-footer dtr-inline sortable" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                        <tr role="row">
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">STT</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" data-defaultsign="AZ">Họ Và Tên</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Chức Vụ</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Ngày Sinh</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Số Điện Thoại</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" data-defaultsign="AZ">Email</th>
                                            @hasrole('admin')
                                                <th class="datatable-nosort sorting_disabled" rowspan="1" colspan="1" aria-label="Action" data-defaultsort="disabled">Thao Tác</th>
                                            @endhasrole
                                        </tr>
                                    </thead>
                                    <tbody class="content_find_admin">
                                        @php
                                            $stt = 0;
                                        @endphp
                                        @foreach ($all_admin as $ad)
                                            @php
                                                $stt++;
                                            @endphp
                                            <tr role="row" class="odd">
                                                <td>{{ $stt }}</td>
                                                <td>
                                                    <div class="name-avatar d-flex align-items-center">
                                                        <div class="avatar mr-2 flex-shrink-0">
                                                            <img src="{{ asset('public/upload/' . $ad->avt) }}" class="border-radius-100 shadow" style="width: 50px; height: 50px;" alt="">
                                                        </div>
                                                        <div class="txt">
                                                            <div class="weight-600">{{ $ad->admin_name }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    @foreach ($roles as $role)
                                                        @if ($role->admin_admin_id == $ad->admin_id)
                                                            <p>
                                                                <i class="icon-copy fa fa-hand-o-right" aria-hidden="true"></i>
                                                                @if ($role->name == 'admin')
                                                                    Quản trị viên
                                                                @elseif($role->name == 'manager')
                                                                    Nhân viên quản lý
                                                                @elseif($role->name == 'employee')
                                                                    Nhân viên
                                                                @elseif($role->name == 'delivery')
                                                                    Nhân viên giao hàng
                                                                @endif
                                                            </p>

                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td>
                                                    {{ date('d/m/Y', strtotime($ad->admin_birthday)) }}
                                                </td>
                                                <td>{{ $ad->admin_phone }}</td>
                                                <td>{{ $ad->admin_email }}</td>
                                                @hasrole('admin')
                                                    <td>
                                                        <div class="dropdown">
                                                            <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                                <i class="dw dw-more"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                                <a class="dropdown-item" href="{{ URL::to('admin/view_profile/' . $ad->admin_id) }}"><i class="dw dw-eye"></i>Thông tin cá nhân</a>
                                                                <a class="dropdown-item" href="{{ URL::to('admin/update_admin/' . $ad->admin_id) }}"><i class="dw dw-edit2"></i>Chỉnh Sửa</a>

                                                                @if (Session::get('admin_id') != $ad->admin_id)
                                                                    <button class="dropdown-item soft_delete_admin_class" data-id="{{ $ad->admin_id }}" data-toggle="modal" data-target="#Modal_delete"><i class="dw dw-delete-3"></i>Xóa</button>
                                                                @endif
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
                        <div class="row">

                            <div class="col-sm-12 col-md-5">
                                @hasrole(['admin'])
                                    <a href="{{ URL::to('admin/view_recycle') }}" class="btn color-btn-them ml-10" style="color: white"><i class="dw dw-delete-3"></i> Thùng Rác</a>
                                @endhasrole
                            </div>
                            <div class="col-sm-12 col-md-7">
                                <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                                    <ul class="pagination">
                                        {!! $all_admin->links() !!}
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
                        <form action="{{ URL::to('admin/soft_delete') }}" method="post" name="form_soft_delete">
                            @csrf
                            <input type="hidden" class="id_delete_admin" name="admin_id" value="">
                        </form>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button class="btn btn-danger btn_delete_soft">Xóa</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- include modal filter --}}
        @include('admin.admin.modal_filter_admin')
    @endsection
