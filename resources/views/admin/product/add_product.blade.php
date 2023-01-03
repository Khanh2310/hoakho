@extends('admin.layout_admin')
@section('container')
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ URL::to('admin/') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Thêm sản phẩm</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                </div>
            </div>
        </div>
        {{-- MESSAGE --}}
        @if (session('add_product_error_name'))
            <div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session('add_product_error_name') }}
            </div>
        @endif
        @if (session('add_product_error'))
            <div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session('add_product_error') }}
            </div>
        @endif
        {{--  --}}
        <div class="pd-20 card-box mb-30">
            <div class="pd-20">
                <h4 class="text-blue h4">Thêm Quản Sản Phẩm</h4>
            </div>
            <div class="pd-20">
                <form action="{{ URL::to('admin/process_add_product') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Tên Sản Phẩm</label>
                                <input class="form-control upper_val format_name_input" type="text" name="product_name"
                                    value="{{ old('product_name') }}" onblur="return upberFirstKey()"
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
                                    <option value="">---Chọn Loại Sản Phẩm-----</option>
                                    @foreach ($category as $cate)
                                        <option value="{{ $cate->cate_id }}">{{ $cate->cate_name }}</option>
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
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Giá Sản Phẩm</label>
                                <input class="form-control upper_val" type="number" name="product_price"
                                    value="{{ old('product_price') }}"
                                    placeholder="Nhập Giá Của Sản Phẩm">
                                @if ($errors->has('product_price'))
                                    <div class="alert alert-danger alert-dismissible mt-1">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        {{ $errors->first('product_price') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Số Lượng Nhập</label>
                                <input class="form-control" type="number" name="product_quantity"
                                    value="{{ old('product_quantity') }}" placeholder="Số Lượng Nhập Hàng">
                                @if ($errors->has('product_quantity'))
                                    <div class="alert alert-danger alert-dismissible mt-1">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        {{ $errors->first('product_quantity') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Đơn Vị Tính Sản Phẩm</label>
                                <select name="unit_id" value="{{ old('unit_id') }}" class="custom-select2 form-control select2-hidden-accessible"
                                    style="width: 100%; height: 38px;" data-select2-id="2" tabindex="-1" aria-hidden="true">
                                    <option value="">---Chọn Đơn Vị Tính-----</option>
                                    @foreach ($unit_product as $unit)
                                        <option value="{{ $unit->unit_id }}">{{ $unit->unit_name }}</option>
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
                                    <option value="">---Chọn Kho--</option>
                                    @foreach ($storage as $sto)
                                        <option value="{{ $sto->storage_id }}">{{ $sto->storage_name }}</option>
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

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Hình Ảnh Sản Phẩm</label>
                                <input class="form-control" type="file" name="product_image" id="file_upload" onchange="return uploadhinh()"
                                    value="{{ old('product_image') }}" placeholder="Chọn Hình Ảnh">
                            </div>
                        </div>
                        <div class="col-3" id="content_image_upload op-0">
                            <img src="" class="op-0" alt="hình ảnh" id="image_upload" height="100px" width="100px">
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Mô Tả Ngắn Về Sản Phẩm</label>
                                <textarea name="product_sort_desc" value = "" class="form-control" id="ck_admin_add_product_sort_desc">{{ old('product_sort_desc') }}</textarea>
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
                                <textarea name="product_desc" value = "" class="form-control" id="ck_admin_add_product_desc">{{ old('product_desc')}}</textarea>
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
                        <input type="submit" class="btn color-btn-them" value="Thêm Sản Phẩm">
                    </div>
                </form>
            </div>
        </div>
    @endsection
