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
                            <li class="breadcrumb-item active" aria-current="page">Sửa kho</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                </div>
            </div>
        </div>
        <div class="pd-20 card-box mb-30">
            <div class="pd-20">
                <h4 class="text-blue h4">Sửa Kho</h4>
            </div>
            <div class="pd-20">
                <div class="row">
                    <div class="col-md-3 col-sm-12"></div>
                    <div class="col-md-6 col-sm-12">
                        <form action="{{ URL::to('admin/process_update_storage_when_find') }}" method="post">
                            @csrf
                            <label>Tên Kho hàng</label>
                            <input type="hidden" name="storage_id" value="{{ $storage->storage_id }}">
                            <input type="text" class="form-control format_name_input" name="storage_name" value="{{ $storage->storage_name }}">
                            <div class="center mr-t mt-5">
                                <button type="submit" class="btn color-btn-them"><i class="icon-copy fi-page-edit"></i>Chỉnh Sửa
                                    Loại Sản Phẩm</button>
                                <a href="" class="btn btn-danger">
                                    <i class="icon-copy fi-x"></i> Hủy Thay Đổi
                                </a>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-3 col-sm-12"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
