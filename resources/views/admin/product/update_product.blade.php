@extends('admin.layout_admin')
@section('container')
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ URL::to('admin/') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item"><a href="{{ URL::to('admin/all_product') }}">Danh sách sản phẩm</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Chỉnh sửa thông tin sản phẩm</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                </div>
            </div>
        </div>
        {{-- MESSAGE --}}
        @if (session('update_product_error_name'))
            <div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session('update_product_error_name') }}
            </div>
        @endif
        {{--  --}}

        <div class="pd-20 card-box mb-30">
            <div class="pd-20">
                <h4 class="text-blue h4">Chỉnh Sửa Thông Tin Sản Phẩm</h4>
            </div>
            <div class="pd-20">
                <form action="{{ URL::to('admin/process_update_product/'.$update_product->product_id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Tên Sản Phẩm</label>
                                <input class="form-control upper_val format_name_input" type="text" name="product_name"
                                    value="{{ $update_product->product_name }}" onblur="return upberFirstKey()"
                                    placeholder="Nhập Tên Sản Phẩm">
                                @if ($errors->has('product_name'))
                                    <div class="alert alert-danger alert-dismissible mt-1">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        {{ $errors->first('product_name') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Loại Sản Phẩm</label>
                                <select name="cate_id" value="{{ old('cate_id') }}" class="custom-select2 form-control select2-hidden-accessible"
                                    style="width: 100%; height: 38px;" data-select2-id="1" tabindex="-1" aria-hidden="true">
                                    @foreach ($category as $cate)
                                        @if ($cate->cate_id == $update_product->category_id)
                                            <option value="{{ $cate->cate_id }}" selected>{{ $cate->cate_name }}</option>
                                        @else
                                            <option value="{{ $cate->cate_id }}">{{ $cate->cate_name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @if ($errors->has('cate_id'))
                                    <div class="alert alert-danger alert-dismissible mt-1">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        {{ $errors->first('cate_id') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Đơn Vị Tính Sản Phẩm</label>
                                <select name="unit_id" value="{{ old('unit_id') }}" class="custom-select2 form-control select2-hidden-accessible"
                                    style="width: 100%; height: 38px;" data-select2-id="2" tabindex="-1" aria-hidden="true">
                                    @foreach ($unit_product as $unit)
                                        @if ($unit->unit_id == $update_product->unit_id)
                                            <option value="{{ $unit->unit_id }}" selected>{{ $unit->unit_name }}</option>
                                        @else
                                            <option value="{{ $unit->unit_id }}">{{ $unit->unit_name }}</option>
                                        @endif

                                    @endforeach
                                </select>
                                @if ($errors->has('unit_id'))
                                    <div class="alert alert-danger alert-dismissible mt-1">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        {{ $errors->first('unit_id') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Kho</label>
                                <select name="storage_id" value="{{ old('storage_id') }}" class="custom-select2 form-control select2-hidden-accessible"
                                    style="width: 100%; height: 38px;" data-select2-id="3" tabindex="-1" aria-hidden="true">
                                    @foreach ($storage as $sto)
                                        @if ($sto->storage_id == $storage_product->storage_id)
                                            <option value="{{ $sto->storage_id }}" selected>{{ $sto->storage_name }}</option>
                                        @else
                                            <option value="{{ $sto->storage_id }}">{{ $sto->storage_name }}</option>
                                        @endif

                                    @endforeach
                                </select>
                                @if ($errors->has('storage_id'))
                                    <div class="alert alert-danger alert-dismissible mt-1">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        {{ $errors->first('storage_id') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Hình Ảnh Sản Phẩm</label>
                                <input class="form-control" type="file" name="product_image" id="file_upload" onchange="return uploadhinh()"
                                    value="{{ old('product_image') }}" placeholder="Chọn Hình Ảnh">
                            </div>
                        </div>
                        <div class="col-2" id="">
                            <img src="{{ asset('public/upload/'.$update_product->product_image) }}" class="" alt="hình ảnh" id="image_upload" height="100px" width="100px">
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Mô Tả Ngắn Về Sản Phẩm</label>
                                <textarea name="product_sort_desc" class="form-control" id="ck_admin_add_product_sort_desc">
                                    {{ $update_product->product_sort_desc }}
                                </textarea>
                                @if ($errors->has('product_sort_desc'))
                                    <div class="alert alert-danger alert-dismissible mt-1">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        {{ $errors->first('product_sort_desc') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Mô Tả Sản Phẩm</label>
                                <textarea name="product_desc" class="form-control" id="ck_admin_add_product_desc">
                                    {{ $update_product->product_desc }}
                                </textarea>
                                @if ($errors->has('product_desc'))
                                    <div class="alert alert-danger alert-dismissible mt-1">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        {{ $errors->first('product_desc') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="center mr-t">
                        <button type="submit" class="btn color-btn-them" value="Chỉnh Sửa Thông Tin Sản Phẩm"><i class="icon-copy fi-page-edit"></i> Chỉnh Sửa Thông Tin Sản Phẩm</button>
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal_close_change"><i class="icon-copy fi-x"></i> Hủy Thay Đổi</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal fade" id="modal_close_change">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title center">Thông Báo</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        Bạn Muốn Hủy Thay Đổi
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger confirm" data-dismiss="modal">Hủy</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                    </div>
                </div>
            </div>
        </div>
    @endsection
