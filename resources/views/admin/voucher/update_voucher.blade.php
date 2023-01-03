@extends('admin.layout_admin')
@section('container')
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ URL::to('admin/') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item"><a href="{{ URL::to('admin/all_product_voucher') }}">Danh sách sản phẩm voucher</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Sửa voucher</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                </div>
            </div>
        </div>
        <div class="pd-20 card-box mb-30">
            <div class="pd-20">
                <h4 class="text-blue h4">Sửa Voucher</h4>
            </div>
            <div class="pd-20">
                <form action="{{ URL::to('admin/process_update_voucher/' . $voucher->voucher_id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Tên Voucher</label>
                                <input class="form-control upper_val" type="text" name="voucher_name" value="{{ $voucher->voucher_name }}" onblur="return upberFirstKey()" placeholder="Nhập Tên Voucher">
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
                                <select name="product_id" value="{{ $voucher->product_id }}" class="custom-select2 form-control select2-hidden-accessible" style="width: 100%; height: 38px;"
                                    data-select2-id="1" tabindex="-1" aria-hidden="true">
                                    <option value="">Chọn voucher cho sản phẩm</option>
                                    @foreach ($all_product as $product)
                                        <option value="{{ $product->product_id }}" @if ($product->product_id == $voucher->product_id)
                                            selected
                                    @endif
                                    >{{ $product->product_name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('product_id'))
                                    <div class="alert alert-danger alert-dismissible mt-1">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        {{ $errors->first('product_id') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Mã Voucher</label>
                                <input class="form-control" type="text" name="voucher_code" value="{{ $voucher->voucher_code }}" placeholder="VD: VOUCHER123" style="text-transform: uppercase;">
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
                                <input class="form-control" type="datetime-local" name="start_date" value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime($voucher->start_date)) }}">
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
                                <input class="form-control" type="datetime-local" name="end_date" value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime($voucher->end_date)) }}">
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
                                    <select name="voucher_type" class="selectpicker form-control" data-size="5" readonly>
                                        <option value="1">Giảm theo tiền</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Mệnh Giá</label>
                                <input class="form-control" type="number" name="voucher_amount" value="{{ $voucher->voucher_amount }}" placeholder="Nhập Số Tiền/Phần Trăm Của Voucher">
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
                                <input class="form-control" type="number" name="voucher_quantity" value="{{ $voucher->voucher_quantity }}" placeholder="Nhập Số Lượng Của Voucher">
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
                        <input type="submit" class="btn color-btn-them" value="Sửa Voucher">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
