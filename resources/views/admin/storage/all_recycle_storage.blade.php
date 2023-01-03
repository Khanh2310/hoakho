@extends('admin.layout_admin')
@section('container')
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ URL::to('admin/') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item"><a href="{{ URL::to('admin/all_storage') }}">Danh sách kho hàng</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Thùng rác</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                </div>
            </div>
        </div>

        <div class="card-box mb-30">
            @if (session('success_delete_forever_storage'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ session('success_delete_forever_storage') }}
                </div>
            @endif
        </div>

        <div class="card-box mb-30">
            @if (session('error_check_storage_name'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    @php
                        $storage_id_recycle = session('storage_id');
                    @endphp
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ session('error_check_storage_name') }} <a href="delete_recovery_forever_storage/{{ $storage_id_recycle }}" class="btn btn-danger">Xóa Khỏi Thùng Rác</a>
                </div>
            @endif
        </div>

        <div class="card-box mb-30">
            @if (session('success_recovery_storage'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ session('success_recovery_storage') }}
                </div>
            @endif
        </div>

        <!-- Simple Datatable start -->
        <div class="pd-20 card-box mb-30">
            <div class="pd-20">
                <h4 class="text-blue h4">Thùng Rác</h4>
            </div>
            @if(count($recycle_item)>0)
                <div class="pb-20">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="row">
                            <div class="col-12 col-md-6 table-responsive">
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div id="DataTables_Table_0_filter" class="dataTables_filter">
                                    <form action="">
                                        @csrf
                                        <label>Tìm Kiếm:<input type="search" class="form-control form-control-sm" id="val_find_recycle" placeholder="Tìm Kiếm"
                                            aria-controls="DataTables_Table_0"></label>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th scope="col">STT</th>
                                        <th scope="col">Tên Loại</th>
                                        <th scope="col">Thao Tác</th>
                                    </tr>
                                    </thead>
                                    <tbody id="table_find_recycle">
                                        @php
                                            $stt = 1;
                                        @endphp
                                    @foreach ($recycle_item as $recy)
                                        <tr>
                                            <td>{{ $stt++ }}</td>
                                            <td>{{ $recy->storage_name }}</td>
                                            <td class="col-4">
                                                <a href="{{ URL::to('admin/re_delete_storage/'.$recy->storage_id) }}" class="btn color-btn-them"
                                                    > Khôi Phục</a>
                                                <button class="btn btn-danger btn_delete_forever" data-id="{{ $recy->storage_id }}" data-toggle="modal" data-target="#delete_forever"> Xóa Vĩnh Viễn</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-12 col-md-7">
                                <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                                    <ul class="pagination">
                                        {{-- {!! $all_admin->links() !!} --}}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="center">Thùng Rác Rổng</div>
            @endif
        </div>
        <!-- The Modal -->
        <div class="modal fade" id="delete_forever">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title center">Thông Báo</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        Bạn có chắc chắn muốn xóa vĩnh viễn dữ liệu này ?
                        <form action="{{ URL::to('admin/delete_forever_storage') }}" method="post" name="form_delete_forever">
                            @csrf
                            <input type="hidden" value="" name="storage_id_delete_forever" class="storage_id_delete_forever">
                        </form>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn_confirm_delete_forever" data-dismiss="modal">Đồng Ý</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    </div>
                </div>
            </div>
        </div>
    @endsection
