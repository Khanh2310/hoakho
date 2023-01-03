@extends('admin.layout_admin')
@section('container')
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ URL::to('admin/') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item"><a href="{{ URL::to('admin/all_product_voucher') }}">Danh sách
                                    voucher</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Thêm voucher</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                </div>
            </div>
        </div>
        <div class="pd-20 card-box mb-30">
            <div class="pd-20">
                <h4 class="text-blue h4">Thêm Voucher</h4>
            </div>
            <div class="pd-20">
                <form action="{{ URL::to('admin/process_add_voucher') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Tên Voucher</label>
                                <input class="form-control upper_val format_name_input" type="text" name="voucher_name" value="{{ old('voucher_name') }}" onblur="return upberFirstKey()"
                                    placeholder="Nhập Tên Voucher">
                                @if ($errors->has('voucher_name'))
                                    <div class="alert alert-danger alert-dismissible mt-1">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        {{ $errors->first('voucher_name') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Tên Sản Phẩm</label>
                                <input class="form-control upper_val" type="text" value="{{ $product->product_name }}" readonly>
                                <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Mã Voucher</label>
                                <input class="form-control" type="text" name="voucher_code" value="{{ old('voucher_code') }}" placeholder="VD: VOUCHER123" style="text-transform: uppercase;">
                                @if ($errors->has('voucher_code'))
                                    <div class="alert alert-danger alert-dismissible mt-1">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        {{ $errors->first('voucher_code') }}
                                    </div>
                                @endif
                                @if (session('voucher_code'))
                                    <div class="alert alert-danger alert-dismissible mt-1">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        {{ session('voucher_code') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Ngày Bắt Đầu</label>
                                <input class="form-control" type="datetime-local" name="start_date" value="{{ old('start_date') }}">
                                @if ($errors->has('start_date'))
                                    <div class="alert alert-danger alert-dismissible mt-1">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        {{ $errors->first('start_date') }}
                                    </div>
                                @endif
                                @if (session('start_date'))
                                    <div class="alert alert-danger alert-dismissible mt-1">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        {{ session('start_date') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Ngày Kết Thúc</label>
                                <input class="form-control" type="datetime-local" name="end_date" value="{{ old('end_date') }}">
                                @if ($errors->has('end_date'))
                                    <div class="alert alert-danger alert-dismissible mt-1">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        {{ $errors->first('end_date') }}
                                    </div>
                                @endif
                                @if (session('end_date'))
                                    <div class="alert alert-danger alert-dismissible mt-1">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        {{ session('end_date') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Hình Thức Voucher</label>
                                <div class="dropdown bootstrap-select form-control dropup">
                                    <select name="voucher_type" class="selectpicker form-control" data-size="5">
                                        <option value="1">Giảm theo tiền</option>
                                        <option value="2">Giảm theo %</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Mệnh Giá</label>
                                <input class="form-control" type="number" name="voucher_amount" value="{{ old('voucher_amount') }}" placeholder="Nhập Số Tiền/Phần Trăm Của Voucher">
                                @if (session('voucher_amount'))
                                    <div class="alert alert-danger alert-dismissible mt-1">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        {{ session('voucher_amount') }}
                                    </div>
                                @endif
                                @if ($errors->has('voucher_amount'))
                                    <div class="alert alert-danger alert-dismissible mt-1">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        {{ $errors->first('voucher_amount') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Số Lượng</label>
                                <input class="form-control" type="number" name="voucher_quantity" value="{{ old('voucher_quantity') }}" placeholder="Nhập Số Lượng Của Voucher">
                                @if ($errors->has('voucher_quantity'))
                                    <div class="alert alert-danger alert-dismissible mt-1">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        {{ $errors->first('voucher_quantity') }}
                                    </div>
                                @endif
                                @if (session('check_voucher_quantity'))
                                    <div class="alert alert-danger alert-dismissible mt-1">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        {{ session('check_voucher_quantity') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="center mr-t">
                        <button type="submit" class="btn color-btn-them" value="Chỉnh Sửa Quản Trị Viên"><i class="icon-copy fi-page-edit"></i>Thêm Voucher</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
