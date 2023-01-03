@extends('admin.layout_admin')
@section('container')
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ URL::to('admin/dashboard') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ URL::to('admin/all_product') }}">Danh sách sản phẩm</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Thùng rác</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                </div>
            </div>
        </div>
        {{-- Message --}}
        @if (session('restore_success'))
            <div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session('restore_success') }}
            </div>
        @endif
        @if (session('delete_product_forever_success'))
            <div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session('delete_product_forever_success') }}
            </div>
        @endif


        <!-- Simple Datatable start -->
        <div class="pd-20 card-box mb-30">
            <div class="pd-20">
                <h4 class="text-blue h4">Thùng Rác</h4>
            </div>
            @if(count($recycle_item)>0)
                <div class="pb-20">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer ">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
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
                            <div class="col-12 table-responsive">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th scope="col">STT</th>
                                        <th scope="col">Hình Ảnh</th>
                                        <th scope="col">Tên Sản Phẩm</th>
                                        <th scope="col">Ngày Xóa</th>
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
                                            <td class="table-plus" tabindex="0">
                                                <div class="da-card box-shadow" style="height: 80px; width: 80px">
                                                    <div class="da-card-photo">
                                                        <img src="{{ asset('public/upload/' . $recy->product_image) }}" alt="hình ảnh"
                                                            srcset="" style="height: 80px; width: 80px">
                                                        <div class="da-overlay">
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $recy->product_name }}</td>
                                            <td>
                                                {{ date('d-m-Y H:i', strtotime($recy->deleted_at)) }}
                                            </td>
                                            <td class="col-4">
                                                <a href="{{ URL::to('admin/re_delete_product/'.$recy->product_id) }}" class="btn color-btn-them"
                                                    > Khôi Phục</a>
                                                <button class="btn btn-danger btn_delete_forever_product" data-id="{{ $recy->product_id }}" data-toggle="modal" data-target="#delete_forever_product"> Xóa Vĩnh Viễn</button>
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
        <div class="modal fade" id="delete_forever_product">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title center">Thông Báo</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        Bạn có chắc chắn muốn xóa vĩnh viễn sản phẩm này ?
                        <form action="{{ URL::to('admin/delete_forever_product') }}" method="post" name="form_delete_forever_product">
                            @csrf
                            <input type="hidden" value="" name="product_id_delete_forever" class="product_id_delete_forever">
                        </form>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn_confirm_delete_forever_product" data-dismiss="modal">Đồng Ý</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    </div>
                </div>
            </div>
        </div>
    @endsection
